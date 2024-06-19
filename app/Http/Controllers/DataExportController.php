<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Video;
use Illuminate\Support\Facades\Response;

class DataExportController extends Controller
{
    public function exportCsv()
    {
        $data = Feedback::all();
        $filename = "rating.csv";
        $handle = fopen($filename, 'w');
        fputcsv($handle, array('video_id', 'Video Title', 'Video Resolution','Visual Quality Experience', 'Streaming Quality', 'User Interface (UI) and Navigation', 'rating', 'Users Opinion')); // add your column headers here

        foreach ($data as $row) {
            $video = Video::find($row->video_id); // Retrieve the video record
            $videoTitle = $video ? $video->title : 'N/A';
            $resolution = $video ? $video->resolution : 'N/A';  // Get the title or default to 'N/A'
            fputcsv($handle, array($row->video_id, $videoTitle, $resolution, $row->r1, $row->r2, $row->r3, $row->rating, $row->comment)); // add your data columns here
        }

        fclose($handle);

        $headers = array(
            'Content-Type' => 'text/csv',
        );

        return Response::download($filename, 'ratingwithopinion.csv', $headers);
    }
}
