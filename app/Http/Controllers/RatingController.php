<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class RatingController extends Controller
{
    public function download($videoId)
    {
        $video = Video::findOrFail($videoId);
        $videoTitle = $video ? $video->title : 'N/A';
        $resolution = $video ? $video->resolution : 'N/A'; 
        $ratings = Feedback::where('video_id', $videoId)->get();

        $csvFileName = 'ratings_' . $video->id . '.csv';

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $columns = ['Video Title', 'Additional Information', 'Visual Quality Experience', 'Streaming Quality', 'User Interface (UI) and Navigation', 'Overall Rating', 'User Opinion'];

        $callback = function() use ($ratings, $columns, $videoTitle, $resolution) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
        
            foreach ($ratings as $rating) {
                $row = [];

                $row['Video Title'] = $videoTitle;
                $row['Additional Information'] = $resolution;
                $row['Visual Quality Experience'] = $rating->r1;
                $row['Streaming Quality'] = $rating->r2;
                $row['User Interface (UI) and Navigation'] = $rating->r3;
                $row['Overall Rating'] = $rating->rating;
                $row['User Opinion'] = $rating->comment;
        
                fputcsv($file, array($videoTitle, $resolution, $row['Visual Quality Experience'], $row['Streaming Quality'], $row['User Interface (UI) and Navigation'], $row['Overall Rating'], $row['User Opinion']));
            }
        
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
