@extends('layouts.master-dashboard')

@section('header')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Management Frame</a></li>
                        <li class="breadcrumb-item" aria-current="page">List Frame</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">List Frame</h2>
                    </div>
                    <div class="mt-3">
                        <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFrameModal" style="border-radius: 255px;">
                            <i class="ph-duotone ph-upload-simple me-1"></i>Tambah Frame
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Frame</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($frames as $frame)
                                <tr>
                                    <td>{{ $frame->id }}</td>
                                    <td>
                                        <img src="{{ $frame->path }}" height="200px" width="auto">
                                    </td>
                                    <td>
                                        <a href="/dashboard/frame/edit-posisi/{{ $frame->id }}" class="btn btn-primary btn-sm">Edit Posisi</a>
                                        <a href="/dashboard/frame/delete/{{ $frame->id }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this frame?')">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Frame -->
<div class="modal fade" id="addFrameModal" tabindex="-1" aria-labelledby="addFrameModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFrameModalLabel">Tambah Frame</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('frames.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="frameImage" class="form-label">Pilih Gambar Frame</label>
                        <input type="file" class="form-control" id="frameImage" name="frame_image" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Frame</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
