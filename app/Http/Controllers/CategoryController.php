<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Video;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = Category::latest();

            $totalRecords = Category::count();

            if ((!empty($request['filter_name'])) &&  ($request->has('filter_name'))) {
                $query->where('name', 'like', '%' . $request->input('filter_name') . '%');
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

                if (!empty($record->image)) {
                    $image = '<img src="' . $record->image . '" height="40px" />';
                } else {
                    $image = 'No Image';
                }
                $record->image = $image;
                
                $record->status = ($record->status == 1) ?
                    '<span class="badge badge-pill badge-soft-success font-size-14 ml-2">Active</span>' :
                    '<span class="badge badge-pill badge-soft-danger font-size-14 ml-2">InActive</span>';

                $record->actions = '<div class="d-flex btn-group-lg" role="group" aria-label="Basic example">
                                       <div style="margin-right:10px"> <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $record->id . '" data-original-title="Edit" class="mr-3 btn btn-outline-primary btn-sm editCategory"><i class="fa fa-edit"></i> Edit</a> </div>
                                       <div style="margin-right:10px"> <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $record->id . '" data-original-title="Delete" class="mr-3 btn btn-outline-danger btn-sm deleteCategory"><i class="fa fa-trash"></i> Delete</a> </div>
                                      </div>';
            }

            return response()->json([
                'draw' => isset($draw) ? intval($draw) : 1,
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $data,
            ]);
        }
        
        return view('admin.category.index');
    }

    public function store(Request $request)
    {
        // if ($request->has('trending') && $request->trending == '1') {
        //     $request['trending'] = 1;
        // } else {
        //     $request['trending'] = 0;
        // }

        if ($request->has('status') && $request->status == '1') {
            $request['status'] = 1;
        } else {
            $request['status'] = 0;
        }

        if (!empty($request->category_id)) {

            $category = Category::find($request->category_id);
            $category->name = $request->name;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $filename = time() . '.' . $ext;
                $file->move(public_path('category_images'), $filename);
                $category->image = 'category_images/' . $filename;
            }
            // $category->trending = $request->trending;
            $category->status = $request->status;
            $category->update();

            return response()->json(['success' => 'Category updated successfully.']);
        } else {

            $originalSlug = Str::slug($request->name);
            $counter = 1;

            $category = new Category();
            $category->name = $request->name;
            $slug = $originalSlug;

            while (Category::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            $category->slug = $slug;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $filename = time() . '.' . $ext;
                $file->move(public_path('category_images'), $filename);
                $category->image = 'category_images/' . $filename;
            }

            $category->status = $request->status;
            $category->save();

            return response()->json(['success' => 'Category added successfully.']);
        }
    }


    public function edit($id)
    {
        $category = Category::find($id);
        $responseData = [
            'category' => $category,
        ];
        return response()->json($responseData);
    }

    public function destroy($id)
    {
        Video::where('category_id', $id)->delete();
        Category::find($id)->delete();
        return response()->json(['success' => 'Category deleted successfully.']);
    }
}
