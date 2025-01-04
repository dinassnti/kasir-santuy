@extends('layouts.app')

@section('title', 'Kasir Santuy')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom text-left">
    <h1 class="h2">Selamat Datang di Kasir Suantuyyyy</h1>
</div>

<div class="row">
    <!-- Card for Jumlah Produk -->
    <div class="col-md-6 mb-5">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Jumlah Produk</h5>
                <p class="card-text">{{ $jumlahProduk }} Produk</p>
            </div>
        </div>
    </div>

    <!-- Card for Jumlah Transaksi (UI only, not connected to DB yet) -->
    <div class="col-md-6 mb-5">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Jumlah Transaksi</h5>
                <p class="card-text">{{ $jumlahTransaksi }} Transaksi</p>  <!-- Static number, will be dynamic later -->
            </div>
        </div>
    </div>
</div>

<!-- Flash Message -->
@if(session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script>
    feather.replace();
</script>
@endpush

@endsection
