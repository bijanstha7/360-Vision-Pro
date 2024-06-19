<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Video;
use Illuminate\Support\Facades\Auth;
class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        
        $review = new Feedback();
        $review->video_id = $request->video_id;
        $review->comment = $request->comment;
        $video = Video::find($request->video_id);
        if ($video->video_type == 'Enhanced') {
            $rating = $request->rating;
            $quality = $request->quality;
            $engagement = $request->engagement;
            $averageRating = round(($rating + $quality + $engagement) / 3);
            $review->rating = $averageRating;
            $review->r1 = $request->rating;
            $review->r2 = $request->quality;
            $review->r3 = $request->engagement;
        }
        $review->save();
        return response()->json(['success' => 'Feedback submitted successfully.']);
    }

    public function index($video_id)
    {
        $reviews = Feedback::where('video_id', $video_id)
                    ->latest()
                    ->take(5)
                    ->get();
        return response()->json($reviews);
    }
}
