<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\File;

class CloudController extends Controller
{
     public function uploadLive(Request $request)
     {
         $path = $request->file('video')->store('uploads/live', 'public');

         $file = File::create([
             'transaction_id' => $request->transaction_id,
             'path' => $path
         ]);
    
         return response()->json(['message' => 'Upload berhasil', 'path' => asset("storage/{$path}")]);
     }

    


    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|file|mimes:png,jpg,jpeg|max:5120', // Maks 5MB
        ]);

        // Simpan file ke dalam penyimpanan Laravel (public/uploads/photos)
        $path = $request->file('photo')->store('uploads/photos', 'public');

        // Simpan informasi ke database (jika diperlukan)
        $file = File::create([
            'transaction_id' => $request->transaction_id,
            'path' => $path
        ]);

        return response()->json(['message' => 'Upload berhasil', 'path' => asset("storage/{$path}")]);
    }

    public function downloadFiles($id)
    {
        $files = File::where('transaction_id', $id)->get();

        if ($files->isEmpty()) {
            return back()->with('error', 'No files found.');
        }

        $downloadLinks = [];

        foreach ($files as $file) {
            $downloadLinks[] = asset('storage/' . $file->path);
        }

        return view('download_files', compact('downloadLinks'));
    }


}
