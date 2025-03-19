<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\CloudController;
use App\Http\Controllers\FrameController;
use App\Http\Controllers\FramePositionController;


Route::get('/login', [PagesController::class, 'loginPage'])->name('login');

Route::post('/login', [AuthController::class, 'signIn']);

Route::get('/', [PagesController::class, 'homePage']);

Route::get('/cam', [PagesController::class, 'camPage']);

Route::post('/upload-images', function (Request $request) {
    $images = $request->input('images');
    $videos = $request->input('videos');
    $savedImages = [];
    $savedVideos = [];

    // Save images (unchanged)
    foreach ($images as $index => $image) {
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = 'photo_' . time() . '_' . $index . '.png';
        Storage::disk('public')->put($imageName, base64_decode($image));
        $savedImages[] = asset('storage/' . $imageName);
    }

    // Save videos (base64 encoded)
    foreach ($videos as $index => $video) {
        $video = str_replace(' ', '+', $video);  // Make sure spaces are replaced with '+'
        $videoName = 'video_' . time() . '_' . $index . '.webm'; // Save as .webm, or .mp4 if you prefer
        Storage::disk('public')->put($videoName, base64_decode($video));
        $savedVideos[] = asset('storage/' . $videoName);
    }

    // Store images and videos in the session
    session(['captured_images' => $savedImages, 'captured_videos' => $savedVideos]);

    return response()->json(['success' => true]);
});

Route::post('/upload-video', function (Request $request) {
    if ($request->hasFile('video')) {
        $video = $request->file('video');
        $videoName = 'video_' . time() . '.webm';
        $video->storeAs('public', $videoName);

        session(['captured_video' => asset('storage/' . $videoName)]);

        return response()->json(['success' => true, 'video_url' => asset('storage/' . $videoName)]);
    }

    return response()->json(['success' => false, 'message' => 'No video uploaded'], 400);
});

Route::get('/preview', [PagesController::class, 'previewPage']);

Route::post('/get-snap-token', [PaymentController::class, 'getSnapToken']);

Route::group(['middleware' => 'auth', 'prefix' => 'dashboard'], function(){

    Route::resource('voucher', VoucherController::class);

    Route::get('/price', [PagesController::class, 'priceSettingPage']);

    Route::post('/price/update', [PriceController::class, 'updatePrice']);

    Route::get('/frame', [PagesController::class, 'framePage'])->name('frames.index');

    Route::post('/frames', [FrameController::class, 'store'])->name('frames.store');

    // Route untuk menghapus frame
    Route::get('/frame/delete/{id}', [FrameController::class, 'destroy'])->name('frames.destroy');

    Route::get('/frame/edit-posisi/{id}', [PagesController::class, 'posisiFrame']);

    Route::get('/frame/edit-posisi/{frame_id}/tambah-posisi', [PagesController::class, 'tambahPosisiFrame']);

    Route::post('/frame/edit-posisi/{frame_id}/tambah-posisi', [FrameController::class, 'tambahPosisiFrame']);

    Route::get('/frame/edit-posisi/{frame_id}/edit/{position_id}', [PagesController::class, 'editPosisiFrame']);

    Route::post('/frame/edit-posisi/{frame_id}/edit/{position_id}', [FrameController::class, 'editPosisiFrame']);

    Route::get('/frame/edit-posisi/{frame_id}/delete/{position_id}', [FrameController::class, 'deletePosisiFrame']);

});

Route::post('/claim-voucher', [VoucherController::class, 'claimVoucher']);

Route::get('/generate', [VoucherController::class, 'generateVouchers']);

Route::post('/upload/live', [CloudController::class, 'uploadLive']);

Route::post('/upload/photo', [CloudController::class, 'uploadPhoto']);

Route::get('/cloud/{id}', [CloudController::class, 'downloadFiles']);

Route::resource('frame-positions', FramePositionController::class);