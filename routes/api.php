<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CanvasUploadController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/upload-photo', [CanvasUploadController::class, 'uploadPhoto']);
Route::post('/upload-live', [CanvasUploadController::class, 'uploadLive']);
