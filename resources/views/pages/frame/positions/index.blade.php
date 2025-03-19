@extends('layouts.master-dashboard')

@section('header')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Management Frame</a></li>
                        <li class="breadcrumb-item" aria-current="page">List Posisi</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">List Posisi</h2>
                    </div>
                    <div class="mt-3">
                        <a href="/dashboard/frame/edit-posisi/{{ $frame->id }}/tambah-posisi" class="btn btn-primary" id="createVoucherBtn" style="border-radius: 255px;">
                            <i class="ph-duotone ph-upload-simple me-1"></i>Tambah Posisi
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
                                <th>X</th>
                                <th>Y</th>
                                <th>Width</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($positions as $position)
                                <tr>
                                    <td>{{ $position->id }}</td>
                                    <td>{{ $position->x }}</td>
                                    <td>{{ $position->y }}</td>
                                    <td>{{ $position->width }}</td>
                                    <td>
                                        <a href="/dashboard/frame/edit-posisi/{{ $frame->id }}/edit/{{ $position->id }}" class="btn btn-primary btn-sm">Edit</a>
                                        <a href="/dashboard/frame/edit-posisi/{{ $frame->id }}/delete/{{ $position->id }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this position?')">Delete</a>
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

@endsection
