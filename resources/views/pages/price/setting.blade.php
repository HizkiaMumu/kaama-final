@extends('layouts.master-dashboard')

@section('header')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Setting</a></li>
                        <li class="breadcrumb-item" aria-current="page">Price</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Setting Price</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
<form action="/dashboard/price/update" method="POST">
    @csrf
    <div class="mb-3">
        <label for="photobox_price" class="form-label">Photobox Price</label>
        <input type="number" class="form-control" name="photobox_price" id="photobox_price" value="{{ $price->photobox_price }}" required>
    </div>
    <button type="submit" class="btn btn-primary">Update Voucher</button>
</form>
@endsection
