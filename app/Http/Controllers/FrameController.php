<?php

namespace App\Http\Controllers;

use App\Models\Frame;
use App\Models\FramePosition;
use Illuminate\Http\Request;
use Storage;

class FrameController extends Controller
{
    // Menampilkan daftar frame
    public function index()
    {
        $frames = Frame::all();
        return view('frame.index', compact('frames'));
    }

    // Menyimpan frame baru
    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'frame_image' => 'required|image|mimes:jpg,png,jpeg,gif',
        ]);

        // Menyimpan gambar ke storage
        $path = $request->file('frame_image')->store('frames', 'public');

        // Menambahkan prefix '/storage' ke path
        $storagePath = Storage::url($path);

        // Menyimpan data frame ke database
        $frame = new Frame();
        $frame->path = $storagePath;
        $frame->event_id = 1;
        $frame->save();

        return redirect()->route('frames.index')->with('success', 'Frame berhasil ditambahkan!');
    }


    public function destroy($id)
    {
        // Mencari frame berdasarkan ID
        $frame = Frame::findOrFail($id);

        // Hapus file gambar
        \Storage::disk('public')->delete($frame->path);

        // Hapus data frame dari database
        $frame->delete();

        return redirect()->route('frames.index')->with('success', 'Frame berhasil dihapus!');
    }

    public function tambahPosisiFrame(Request $request, $id){
        $position = FramePosition::create([
            'frame_id' => $id,
            'x' => $request->x,
            'y' => $request->y,
            'width' => $request->width,
        ]);

        return redirect('/dashboard/frame/edit-posisi/' . $id);
    }

    public function editPosisiFrame(Request $request, $frame_id, $id){
        $position = FramePosition::find($id);

        $position->update([
            'frame_id' => $frame_id,
            'x' => $request->x,
            'y' => $request->y,
            'width' => $request->width,
        ]);

        return redirect()->back();
    }

    public function deletePosisiFrame($frame_id, $id){
        $position = FramePosition::find($id);
        
        $position->delete();

        return redirect('/dashboard/frame/edit-posisi/' . $frame_id);
    }

}

