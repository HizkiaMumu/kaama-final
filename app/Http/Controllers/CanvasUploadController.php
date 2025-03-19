<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CanvasUploadController extends Controller
{
    public function uploadPhoto(Request $request)
    {
        return $this->uploadImage($request, 'photo-uploads');
    }

    public function uploadLive(Request $request)
    {
        // Validasi request, pastikan file video dikirim
        $request->validate([
            'video' => 'required|file|mimes:webm,mp4,mov,avi|max:51200' // Maksimal 50MB
        ]);

        // Simpan file dengan nama unik
        $videoFile = $request->file('video');
        $filename = 'live_' . Str::random(10) . '.' . $videoFile->getClientOriginalExtension();
        $path = $videoFile->storeAs('public/live_videos', $filename);

        // Kirim response sukses dengan URL video
        return response()->json([
            'success' => true,
            'message' => 'Video berhasil diunggah',
            'video_url' => Storage::url($path),
        ], 201);
    }

    private function uploadImage(Request $request, $directory)
    {
        if (!$request->hasFile('image')) {
            return response()->json(['error' => 'No image uploaded'], 400);
        }

        $image = $request->file('image');
        $path = $image->store($directory, 'public'); // Simpan ke storage/app/public/{directory}

        return response()->json([
            'message' => 'Upload successful',
            'path' => asset("storage/" . $path),
        ]);
    }
}
