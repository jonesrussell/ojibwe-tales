<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'video' => 'required|file|mimes:webm,mp4|max:102400', // Max 100MB
        ]);

        try {
            $file = $request->file('video');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            
            // Store in S3/MinIO
            $path = Storage::disk('s3')->putFileAs(
                'videos',
                $file,
                $filename,
                'public'
            );

            // Save video metadata to database
            $video = Video::create([
                'filename' => $filename,
                'path' => $path,
                'size' => $file->getSize(),
                'status' => 'uploaded',
                'uploaded_at' => now(),
            ]);

            return response()->json([
                'message' => 'Video uploaded successfully',
                'video' => $video,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to upload video',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
} 