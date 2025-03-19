@extends('layouts.master-dashboard')

@section('header')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Management Frame</a></li>
                        <li class="breadcrumb-item" aria-current="page">Edit Position</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Edit Position</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
<form action="/dashboard/frame/edit-posisi/{{ $frame->id }}/edit/{{ $position->id }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="x" class="form-label">X</label>
        <input type="number" class="form-control" name="x" id="x" value="{{ $position->x }}" required>
    </div>
    <div class="mb-3">
        <label for="y" class="form-label">Y</label>
        <input type="number" class="form-control" name="y" id="y" value="{{ $position->y }}" required>
    </div>
    <div class="mb-3">
        <label for="width" class="form-label">Width</label>
        <input type="number" class="form-control" name="width" id="width" value="{{ $position->width }}" required>
    </div>
    <button type="submit" class="btn btn-primary">Edit Position</button>
</form>
@endsection
