@extends('layouts.app') <!-- Assuming you have a layout in the 'resources/views/layouts/app.blade.php' -->

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title">Detail Transaksi #{{ $transaksi->id_transaksi }}</h3>
        </div>
        <div class="card-body">
            <!-- Informasi dasar transaksi -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong>Staff:</strong> 
                        <span class="badge bg-info text-dark">{{ $transaksi->staff ? $transaksi->staff->nama : 'Staff Tidak Ditemukan' }}</span>
                    </p>
                </div>
                <div class="col-md-6">
                    <p><strong>Tanggal Transaksi:</strong> {{ $transaksi->created_at->format('d/m/Y H:i:s') }}</p>
                </div>
                <div class="col-md-12">
                    <p><strong>Toko:</strong> 
                        <span class="badge bg-secondary">{{ $transaksi->toko ? $transaksi->toko->nama_toko : 'Toko Tidak Ditemukan' }}</span>
                    </p>
                </div>
            </div>

            <!-- Diskon (jika ada) -->
            <div class="mb-4">
                @if($transaksi->diskon)
                    <p><strong>Diskon:</strong> 
                        <span class="badge bg-success">{{ $transaksi->diskon->nilai_diskon }}%</span>
                    </p>
                @else
                    <p><strong>Diskon:</strong> 
                        <span class="badge bg-danger">Tidak ada diskon</span>
                    </p>
                @endif
            </div>

            <!-- Detail produk yang dibeli -->
            <h4 class="mb-3">Detail Belanja:</h4>
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
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
                                <td>{{ $detail->produk ? $detail->produk->nama_produk : 'Produk Tidak Ditemukan' }}</td>
                                <td>{{ $detail->jumlah }}</td>
                                <td class="text-end">Rp {{ number_format($detail->subtotal, 2, ',', '.') }}</td>
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
                <h5 class="text-success">Total Belanja: Rp {{ number_format($transaksi->detailTransaksi->sum('subtotal'), 2, ',', '.') }}</h5>
                <p><strong>Jumlah Bayar:</strong> Rp {{ number_format($transaksi->jumlah_bayar, 2, ',', '.') }}</p>
                <p><strong>Kembalian:</strong> Rp {{ number_format($transaksi->kembalian, 2, ',', '.') }}</p>
            </div>

            <!-- Kembali ke daftar transaksi -->
            <div class="mt-4">
                <a href="{{ route('laporan-transaksi.index') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar Transaksi
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
