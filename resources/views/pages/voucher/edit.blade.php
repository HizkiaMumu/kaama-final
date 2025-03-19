@extends('layouts.master-dashboard')

@section('header')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Management Voucher</a></li>
                        <li class="breadcrumb-item" aria-current="page">Edit Voucher</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Edit Voucher</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
<form action="{{ route('voucher.update', $voucher->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="voucher_code" class="form-label">Voucher Code</label>
        <input type="text" class="form-control" name="voucher_code" id="voucher_code" value="{{ $voucher->voucher_code }}" required>
    </div>
    <div class="mb-3">
        <label for="used" class="form-label">Used</label>
        <input type="checkbox" class="form-check-input" name="used" id="used" {{ $voucher->used ? 'checked' : '' }}>
    </div>
    <button type="submit" class="btn btn-primary">Update Voucher</button>
</form>
@endsection
