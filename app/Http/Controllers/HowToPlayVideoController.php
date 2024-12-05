<?php

namespace App\Http\Controllers;

use App\Models\HowToPlayVideo;
use Illuminate\Http\Request;

class HowToPlayVideoController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'video_link' => 'required|url|max:255', // Ensure it's a valid URL
        ]);

        // Check if a video already exists, update or create a new one
        $video = HowToPlayVideo::first();
        if ($video) {
            $video->update($validated);
            $message = 'Video link updated successfully.';
        } else {
            HowToPlayVideo::create($validated);
            $message = 'Video link added successfully.';
        }

        return response()->json([
            'message' => $message,
            'video_link' => $validated['video_link'],
        ], 200);
    }
    public function show()
    {
        $video = HowToPlayVideo::first();

        if (!$video) {
            return response()->json([
                'message' => 'No video link found.',
            ], 404);
        }

        return response()->json([
            'message' => 'Video link retrieved successfully.',
            'video_link' => $video->video_link,
        ], 200);
    }
}
