@extends('layouts.master-dashboard')

@section('header')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Management Voucher</a></li>
                        <li class="breadcrumb-item" aria-current="page">List Voucher</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">List Voucher</h2>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('voucher.create') }}" class="btn btn-primary" id="createVoucherBtn" style="border-radius: 255px;">
                            <i class="ph-duotone ph-upload-simple me-1"></i>Tambah Voucher
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
                                <th>Voucher Code</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vouchers as $voucher)
                                <tr>
                                    <td>{{ $voucher->id }}</td>
                                    <td>{{ $voucher->voucher_code }}</td>
                                    <td>{{ $voucher->used ? 'Used' : 'Unused' }}</td>
                                    <td>
                                        <a href="{{ route('voucher.edit', $voucher->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                        <a href="{{ route('voucher.destroy', $voucher->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this voucher?')">Delete</a>
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
