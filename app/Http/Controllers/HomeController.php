<?php

namespace App\Http\Controllers;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
class HomeController extends Controller
{
    public function index()
    {
        $videos = Video::with(['comments'])
                        ->where('status', 1)
                        ->where('video_type', 'Enhanced')
                        ->latest()
                        ->get()
                        ->map(function ($video) {
                            $video->comments_count = $video->comments->count();
                            $video->average_rating = $video->comments->avg('rating');
                            return $video;
                        });

        if (count($videos) === 0) {
            $videos = '';
        }


        $categories = Category::latest()->where('status', 1)->get(['id', 'name']);
        return view('home.index', compact('videos', 'categories'));
    }

    public function filterVideos(Request $request)
    {
        $categoryId = $request->get('category_id');
        $searchQuery = $request->get('search_query');

        $query = Video::with(['comments'])
                        ->where('video_type', 'Enhanced')
                        ->where('status', 1);

        if ($categoryId && $categoryId != 0) {
            $query->where('category_id', $categoryId);
        }

        if ($searchQuery) {
            $query->where('title', 'LIKE', "%$searchQuery%");
        }
        
        $videos = $query->latest()
                    ->get()
                    ->map(function ($video) {
                        $video->comments_count = $video->comments->count();
                        $video->average_rating = $video->comments->avg('rating');
                        return $video;
                    });
        if (count($videos) === 0) {
            $videos = '';
        }
        
        
        return view('home.video_list', compact('videos'));
    }


    public function profile()
    {
        if (Auth::user()->status == 0) {
            return redirect()->route('home')->with('warning', 'Your status has been temporarily blocked, Please Contact Support.');
        }
        
        $user = Auth::user();
        return view('home.profile', compact('user'));
    }
    public function playVideo($slug)
    {
        $video = Video::where('slug', $slug)->first();
        $recommendations = Video::where('status', 1)
                            ->where('id', '!=', $video->id)
                            ->inRandomOrder()
                            ->take(5)
                            ->get()
                            ->map(function ($video) {
                                $video->comments_count = $video->comments->count();
                                $video->average_rating = $video->comments->avg('rating');
                                return $video;
                            });
        if (count($recommendations) === 0) {
            $recommendations = '';
        }
        return view('home.video_detail', compact('video', 'recommendations'));
    }
    public function uploadVideo()
    {
        if (Auth::user()->status == 0) {
            return redirect()->route('home')->with('warning', 'Your status has been temporarily blocked, Please Contact Support.');
        }
        $categories = Category::latest()->where('status', 1)->get(['id', 'name']);
        return view('home.upload_video', compact('categories'));
    }
    public function userVideos()
    {
        if (Auth::user()->status == 0) {
            return redirect()->route('home')->with('warning', 'Your status has been temporarily blocked, Please Contact Support.');
        }
        $videos = Video::with(['comments'])
                ->where('status', 1)
                ->where('user_id', Auth::id())
                ->latest()
                ->get()
                ->map(function ($video) {
                    $video->comments_count = $video->comments->count();
                    $video->average_rating = $video->comments->avg('rating');
                    return $video;
                });
        if (count($videos) === 0) {
            $videos = '';
        }
        return view('home.user_videos', compact('videos'));
    }
    public function editProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:50',
        ]);
        if (isset($request->password)) {
            $request->validate([
                'password' => 'required|confirmed|min:6'
            ]);
        }
        $id = Auth::id();
        $user = User::find($id);
        if ($request->hasFile('profile_img')) {
            $file = $request->file('profile_img');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move(public_path('profile_photos'), $filename);
            $user->profile_img = $filename;
        }
        $user->name = $request->name;
        if (isset($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->update();
        return redirect()->route('profile')->with('success', 'Settings updated successfully');
    }
    public function uploadVideoSubmit(Request $request)
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
        $video = new Video();
        $video->title = $request->title;
        $video->description = $request->description;
        $video->category_id = $request->category_id;
        $video->user_id = Auth::id();
        $video->video_type = 'Original';

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

        $video->save();
        
       
        return redirect()->route('userVideos')->with('success', 'Video Added Successfully');
    }
}
