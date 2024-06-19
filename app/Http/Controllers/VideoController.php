<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\User;
use App\Models\Category;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class VideoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = Video::where('status', 1)->latest();

            $totalRecords = Video::where('status', 1)->count();

            if ((!empty($request['filter_name'])) &&  ($request->has('filter_name'))) {
                $query->where('title', 'like', '%' . $request->input('filter_name') . '%');
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

                if (!empty($record->thumbnail)) {
                    $image = '<img src="' . $record->thumbnail . '" height="40px" />';
                } else {
                    $image = 'No Image';
                }

                $category = Category::find($record->category_id);
                if (!empty($category)) {
                    $record->category = '<span class="badge badge-pill badge-soft-success font-size-14 ml-2">'.$category->name.'</span>';
                } else {
                    $record->category = '<span class="badge badge-pill badge-soft-danger font-size-14 ml-2">No Category</span>';
                }

                $added_by = User::find($record->user_id);
                if (!empty($added_by)) {
                    $record->added_by = '<span class="badge badge-pill badge-soft-success font-size-14 ml-2">'.$added_by->name.'</span>';
                } else {
                    $record->added_by ='<span class="badge badge-pill badge-soft-danger font-size-14 ml-2">Not found</span>';
                }
                
                $record->image = $image;
                // $record->resolution = $resolution;

                $record->status = ($record->status == 1) ?
                    '<span class="badge badge-pill badge-soft-success font-size-14 ml-2">Active</span>' :
                    '<span class="badge badge-pill badge-soft-danger font-size-14 ml-2">InActive</span>';

                $actions = '<div class="d-flex btn-group-lg" role="group" aria-label="Basic example">
                                    <div style="margin-right:10px">
                                            <div style="margin-right:10px"> <a href="' . route('comments.view') . '?video_id=' . $record->id . '" class="mr-3  btn btn-outline-primary btn-sm"><i class="fa fa-eye"></i> View Feedback</a> </div>
                                    </div>
                                   <div style="margin-right:10px"> <a href="' . route('videos.edit', $record->id) . '" data-toggle="tooltip"  data-id="' . $record->id . '" data-original-title="Edit" class="mr-3  btn btn-outline-primary btn-sm editCategory"><i class="fa fa-edit"></i> Edit</a> </div>
                                   <div>  <form action="' . route('videos.destroy', $record->id) . '" method="POST">' . csrf_field() . '<input name="_method" type="hidden" value="DELETE"><button type="button" class="delete-btn btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i> Delete</button></form>
                                    </div>
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
  
        return view('admin.video.index');
    }
    public function viewComments(Request $request){
        $video_id = $request->video_id;
        $video = Video::find($video_id);
        $ratings = Feedback::where('video_id', $video_id)->latest()->paginate(10);
        if (count($ratings) === 0) {
            $ratings = '';
        }
        return view('admin.video.rating', compact('video', 'ratings'));
    }
    public function create(Request $request)
    {
        $categories = Category::latest()->where('status', 1)->get(['id', 'name']);
        return view('admin.video.add', compact('categories'));
    }
    public function store(Request $request)
    {
        if ($request->has('status') && $request->status == 'on') {
            $request['status'] = 1;
        } else {
            $request['status'] = 0;
        }
        if ($request->has('trending') && $request->trending == 'on') {
            $request['trending'] = 1;
        } else {
            $request['trending'] = 0;
        }
        $video = new Video();
        $video->title = $request->title;
        $video->description = $request->description;
        $video->category_id = $request->category_id;
        $video->user_id = Auth::id();
        $video->video_type = 'Enhanced';
        $video->resolution = $request->resolution;
        

        $originalSlug = Str::slug($request->title);
        $counter = 1;
        $slug = $originalSlug;
        while (Video::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $video->slug = $slug;
        
        $video->status = $request->status;
        $video->trending = $request->trending;
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $ext = $file->getClientOriginalExtension();
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $filename = Str::slug($originalName) . '.' . $ext;
            $file->move(public_path('video_thumbnails'), $filename);
            $video->thumbnail = 'video_thumbnails/' . $filename;
        }
        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $ext = $file->getClientOriginalExtension();
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $filename = Str::slug($originalName) . '.' . $ext;
            $file->move(public_path('uploaded_videos'), $filename);
            $video->video = 'uploaded_videos/' . $filename;
        }
        if ($request->hasFile('enhanced_video')) {
            $file = $request->file('enhanced_video');
            $ext = $file->getClientOriginalExtension();
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $filename = Str::slug($originalName) . '.' . $ext;
            $file->move(public_path('enhanced_videos'), $filename);
            $video->enhanced_video = 'enhanced_videos/' . $filename;
        }

        $video->save();
        
       
        return redirect()->route('videos.index')->with('success', 'Video Added Successfully');
    }
    public function edit(string $id)
    {
        $video = Video::find($id);
        $categories = Category::latest()->where('status', 1)->get(['id', 'name']);
        return view('admin.video.edit', compact('video', 'categories'));
    }
    public function update(Request $request, string $id)
    {
        $image = $request->file('thumbnail');
        $video = $request->file('video');

        if ($request->has('status') && $request->status == 'on') {
            $request['status'] = 1;
        } else {
            $request['status'] = 0;
        }
        if ($request->has('trending') && $request->trending == 'on') {
            $request['trending'] = 1;
        } else {
            $request['trending'] = 0;
        }
        $video = Video::find($id);
        $video->title = $request->title;
        $video->description = $request->description;
        $video->category_id = $request->category_id;
        $video->video_type = 'Enhanced';
        $video->resolution = $request->resolution;
 
        $video->status = $request->status;
        $video->trending = $request->trending;
        if ($request->hasFile('thumbnail')) {
            $file = $image;
            $ext = $file->getClientOriginalExtension();
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $filename = Str::slug($originalName) . '.' . $ext;
            $file->move(public_path('video_thumbnails'), $filename);
            $video->thumbnail = 'video_thumbnails/' . $filename;
        }
        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $ext = $file->getClientOriginalExtension();
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $filename = Str::slug($originalName) . '.' . $ext;
            $file->move(public_path('uploaded_videos'), $filename);
            $video->video = 'uploaded_videos/' . $filename;
        }
        if ($request->hasFile('enhanced_video')) {
            $file = $request->file('enhanced_video');
            $ext = $file->getClientOriginalExtension();
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $filename = Str::slug($originalName) . '.' . $ext;
            $file->move(public_path('enhanced_videos'), $filename);
            $video->enhanced_video = 'enhanced_videos/' . $filename;
        }

        $video->save();
        
       
        return redirect()->route('videos.index')->with('success', 'Video Updated Successfully');
    }
    public function destroy($id)
    {
        Video::find($id)->delete();
        return back()->with('success', 'Video deleted successfully.');
    }
}
