<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Price;
use App\Models\FramePosition;
use App\Models\Frame;

class PagesController extends Controller
{
    
    public function homePage(){
        $data['frames'] = Frame::all();
        return view('pages/home', $data);
    }

    public function camPage(){
        return view('pages/cam');
    }

    public function loginPage(){
        return view('pages/auth/login');
    }

    public function voucherPage(){
        return view('pages/voucher/index');
    }

    public function priceSettingPage(){
        $data['price'] = Price::first();
        return view('pages/price/setting', $data);
    }

    public function previewPage(){
        $data['capturedImages']  = session('captured_images', []);
        $data['capturedVideos']  = session('captured_videos', []);
        $data['transactionId']   = session('transaction_id');
        $data['frame']           = Frame::find($_GET['frameId']);
        $data['frame_positions'] = FramePosition::where('frame_id', $_GET['frameId'])->get();
//dd($data);


        return view('preview', $data);
    }

    public function framePage(){
        $data['frames'] = Frame::all();
        return view('pages/frame/index', $data);
    }

    public function posisiFrame($id){
        $data['frame'] = Frame::find($id);
        $data['positions'] = FramePosition::where('frame_id', $id)->get();
        return view('pages/frame/positions/index', $data);
    }

    public function tambahPosisiFrame($id){
        $data['frame'] = Frame::find($id);
        return view('pages/frame/positions/create', $data);
    }

    public function editPosisiFrame($frame_id, $id){
        $data['frame'] = Frame::find($frame_id);
        $data['position'] = FramePosition::find($id);
        return view('pages/frame/positions/edit', $data);
    }

}
