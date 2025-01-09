@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg border-primary">
        <div class="card-header bg-primary text-white text-center">
            <h3 class="card-title">Detail Transaksi #{{ $transaksi->id_transaksi }}</h3>
        </div>
        <div class="card-body">
            <!-- Informasi dasar transaksi -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong>Kasir:</strong> 
                        {{ $transaksi->user->nama ?? 'Pengguna Tidak Ditemukan' }}
                    </p>
                </div>
                <div class="col-md-6">
                    <p><strong>Tanggal Transaksi:</strong> {{ $transaksi->created_at->format('d/m/Y H:i:s') }}</p>
                </div>
            </div>

            <!-- Diskon (jika ada) -->
            <div class="mb-4">
                @if($transaksi->diskon)
                    <p><strong>Diskon:</strong> 
                        {{ $transaksi->diskon->persentase }}%
                    </p>
                @else
                    <p><strong>Diskon:</strong> 
                        Tidak ada diskon
                    </p>
                @endif
            </div>

            <!-- Detail produk yang dibeli -->
            <h4 class="mb-3">Detail Belanja:</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksi->detailTransaksi as $detail)
                            <tr>
                                <td>{{ $detail->produk->nama_produk ?? 'Produk Tidak Ditemukan' }}</td>
                                <td>{{ $detail->jumlah }}</td>
                                <td class="text-end">Rp {{ number_format($detail->harga_satuan * $detail->jumlah, 2, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">
                                    <div class="alert alert-warning mb-0">
                                        <i class="bi bi-exclamation-circle"></i> Tidak ada detail transaksi.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Total belanja dan informasi pembayaran -->
            <div class="mt-4">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="text-success">Total Belanja:</h5>
                    </div>
                    <div class="col-md-6 text-end">
                        <h5 class="text-success">Rp {{ number_format($transaksi->detailTransaksi->sum('subtotal'), 2, ',', '.') }}</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Jumlah Bayar:</strong>
                    </div>
                    <div class="col-md-6 text-end">
                        Rp {{ number_format($transaksi->jumlah_bayar, 2, ',', '.') }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Kembalian:</strong>
                    </div>
                    <div class="col-md-6 text-end">
                        Rp {{ number_format($transaksi->kembalian, 2, ',', '.') }}
                    </div>
                </div>
            </div>

            <!-- Kembali ke daftar transaksi -->
            <div class="mt-4 text-center">
                <a href="{{ route('laporan-transaksi.index') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar Transaksi
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
