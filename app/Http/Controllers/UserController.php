<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Video;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = User::where('role', 0)->latest();

            $totalRecords = User::where('role', 0)->count();

            if ((!empty($request['filter_name'])) &&  ($request->has('filter_name'))) {
                $query->where('name', 'like', '%' . $request->input('filter_name') . '%');
            }
            if ((!empty($request['filter_email'])) &&  ($request->has('filter_email'))) {
                $query->where('email', 'like', '%' . $request->input('filter_email') . '%');
            }
            if (($request['filter_status'] !== null) && ($request->has('filter_status'))) {
                $query->where('status', $request['filter_status']);
            }
            

            // Count after applying filters
            $filteredRecords = $query->count();

            $length = $request->length ?: env("PER_PAGE_COUNT");
            $start = $request->start > $filteredRecords ? 0 : $request->start;

            $data = $query->skip($start)->take($length)->get();

            $draw = $request->get('draw');

            foreach ($data as $record) {

                $record->active_status = ($record->status == 1) ?
                    '<span class="badge badge-pill badge-soft-success font-size-14 ml-2">Active</span>' :
                    '<span class="badge badge-pill badge-soft-danger font-size-14 ml-2">InActive</span>';

                if ($record->status == '1') {
                    $block_actions = '<div class="d-flex btn-group-lg" role="group" aria-label="Basic example">
                                <div style="margin-right:10px"> <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $record->id . '" data-original-title="Delete" class="mr-3  btn btn-outline-danger btn-sm blockStatus"><i class="fa fa-user-slash"></i> Block</a> </div>
                                </div>';
                } else {
                    $block_actions = '<div class="d-flex btn-group-lg" role="group" aria-label="Basic example">
                                <div style="margin-right:10px"> <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $record->id . '" data-original-title="Delete" class="mr-3  btn btn-outline-success btn-sm UnblockStatus"><i class="fa fa-check"></i> Un-Block</a> </div>
                                </div>';
                }
                $actions = '<div class="d-flex btn-group-lg" role="group" aria-label="Basic example">
                                '. $block_actions .'
                                <div style="margin-right:10px"> <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $record->id . '" data-original-title="Edit" class="mr-3  btn btn-outline-primary btn-sm edituser"><i class="fa fa-edit"></i> Edit</a> </div>
                                <div style="margin-right:10px"> <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $record->id . '" data-original-title="Delete" class="mr-3  btn btn-outline-danger btn-sm deleteuser"><i class="fa fa-trash"></i> Delete</a> </div>
                                </div>';
                $record->actions = $actions;
            }

            return response()->json([
                'draw' => isset($draw) ? intval($draw) : 1,
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $data,
            ]);
        }
        
        return view('admin.users.index');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($request->user_id),
            ],
        ];
        $messages = [
            'email.unique' => 'The email has already added.',
        ];
        $validator = \Validator::make($request->all(), $rules, $messages);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        if ($request->has('status') && $request->status == '1') {
            $request['status'] = 1;
        } else {
            $request['status'] = 0;
        }


        if (!empty($request->user_id)) {

            $user = User::find($request->user_id);
            $user->name = $request->name;
            $user->email = $request->email;
            // if ($request->password) {
            //     $user->password = Hash::make($request->password);
            // }
            $user->status = $request->status;
            $user->update();

            return response()->json(['success' => 'User updated successfully.']);
        }
    }


    public function edit($id)
    {
        $user = User::find($id);
        $responseData = [
            'user' => $user,
        ];
        return response()->json($responseData);
    }

    public function destroy($id)
    {
        Video::where('user_id', $id)->delete();
        User::find($id)->delete();
        return response()->json(['success' => 'User deleted successfully.']);
    }

    public function blockUser($id)
    {
        $user = User::find($id);
        $user->status = '0';
        $user->save();
        return response()->json(['success' => 'User blocked successfully.']);
    }
    public function UnblockUser($id)
    {
        $user = User::find($id);
        $user->status = '1';
        $user->save();
        return response()->json(['success' => 'User un blocked successfully.']);
    }
}
