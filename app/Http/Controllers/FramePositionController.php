<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FramePosition;
use App\Models\Frame;

class FramePositionController extends Controller
{
    public function index()
    {
        $framePositions = FramePosition::with('frame')->get();
        return view('frame_positions.index', compact('framePositions'));
    }

    public function create()
    {
        $frames = Frame::all();
        return view('frame_positions.create', compact('frames'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'frame_id' => 'required|exists:frames,id',
            'x' => 'required|integer',
            'y' => 'required|integer',
            'width' => 'required|integer',
        ]);

        FramePosition::create($request->all());
        return redirect()->route('frame-positions.index')->with('success', 'Frame Position created successfully');
    }

    public function edit(FramePosition $framePosition)
    {
        $frames = Frame::all();
        return view('frame_positions.edit', compact('framePosition', 'frames'));
    }

    public function update(Request $request, FramePosition $framePosition)
    {
        $request->validate([
            'frame_id' => 'required|exists:frames,id',
            'x' => 'required|integer',
            'y' => 'required|integer',
            'width' => 'required|integer',
        ]);

        $framePosition->update($request->all());
        return redirect()->back()->with('success', 'Frame Position updated successfully');
    }

    public function destroy(FramePosition $framePosition)
    {
        $framePosition->delete();
        return redirect()->route('frame-positions.index')->with('success', 'Frame Position deleted successfully');
    }
}