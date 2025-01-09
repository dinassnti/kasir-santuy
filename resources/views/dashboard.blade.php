@extends('layouts.app')

@section('title', 'Kasir Santuy')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom text-left">
    <h1 class="h2">Selamat Datang di Kasir Suantuyyyy</h1>
</div>

<div class="row">
    <!-- Card for Jumlah Produk -->
    <div class="col-md-6 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Jumlah Produk</h5>
                <p class="card-text">{{ $jumlahProduk }} Produk</p>
            </div>
        </div>
    </div>

    <!-- Card for Jumlah Transaksi -->
    <div class="col-md-6 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Jumlah Transaksi</h5>
                <p class="card-text">{{ $jumlahTransaksi }} Transaksi</p>
            </div>
        </div>
    </div>

    <!-- Card for Jumlah Staff -->
    <div class="col-md-6 mb-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title">Jumlah Staff</h5>
                <p class="card-text">{{ $jumlahStaff }} Staff</p>
            </div>
        </div>
    </div>

    <!-- Pendapatan -->
    <div class="col-md-6 mb-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5 class="card-title">Total Pendapatan</h5>
                <p class="card-text">Rp {{ number_format($totalPendapatan, 2, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <!-- Daftar transaksi terbaru -->
    <div class="card mt-4 shadow">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0"><i class="bi bi-list"></i> Transaksi Terbaru</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="table-info">
                        <tr>
                            <th class="text-center" style="width: 15%;">ID Transaksi</th>
                            <th class="text-center" style="width: 25%;">Kasir</th>
                            <th class="text-center" style="width: 30%;">Tanggal</th>
                            <th class="text-center" style="width: 30%;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksiTerbaru as $transaksi)
                            <tr>
                                <td class="text-center">{{ $transaksi->id_transaksi }}</td>
                                <td>{{ $transaksi->user->nama }}</td>
                                <td class="text-center">{{ $transaksi->created_at->format('d/m/Y') }}</td>
                                <td class="text-end">Rp {{ number_format($transaksi->jumlah_bayar, 2, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    <i class="bi bi-exclamation-circle"></i> Tidak ada transaksi terbaru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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
