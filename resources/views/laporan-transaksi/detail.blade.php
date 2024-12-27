@extends('layouts.app') <!-- Assuming you have a layout in the 'resources/views/layouts/app.blade.php' -->

@section('content')
<div class="container mt-4">
    <h2>Detail Transaksi #{{ $transaksi->id_transaksi }}</h2>

    <!-- Informasi dasar transaksi -->
    <div class="row">
        <div class="col-md-6 mb-3">
            <p><strong>Staff:</strong> {{ $transaksi->staff ? $transaksi->staff->nama : 'Staff Tidak Ditemukan' }}</p>
        </div>
        <div class="col-md-6 mb-3">
            <p><strong>Tanggal Transaksi:</strong> {{ $transaksi->created_at->format('d/m/Y H:i:s') }}</p>
        </div>
        <div class="col-md-12 mb-3">
            <p><strong>Toko:</strong> {{ $transaksi->toko ? $transaksi->toko->nama_toko : 'Toko Tidak Ditemukan' }}</p>
        </div>
    </div>

    <!-- Diskon (jika ada) -->
    <div class="mb-4">
        @if($transaksi->diskon)
            <p><strong>Diskon:</strong> {{ $transaksi->diskon->nilai_diskon }}%</p>
        @else
            <p><strong>Diskon:</strong> Tidak ada diskon</p>
        @endif
    </div>

    <!-- Detail produk yang dibeli -->
    <h3>Detail Belanja:</h3>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
                <th>Total Setelah Diskon</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transaksi->detailTransaksi as $detail)
                <tr>
                    <td>{{ $detail->produk ? $detail->produk->nama : 'Produk Tidak Ditemukan' }}</td>
                    <td>{{ $detail->jumlah }}</td>
                    <td>{{ number_format($detail->subtotal, 2) }}</td>
                    <td>{{ number_format($detail->total, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada detail transaksi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Total belanja dan informasi pembayaran -->
    <div class="mt-4">
        <h4>Total Belanja: {{ number_format($transaksi->detailTransaksi->sum('subtotal'), 2) }}</h4>
        <p><strong>Jumlah Bayar:</strong> {{ number_format($transaksi->jumlah_bayar, 2) }}</p>
        <p><strong>Kembalian:</strong> {{ number_format($transaksi->kembalian, 2) }}</p>
    </div>

    <!-- Kembali ke daftar transaksi -->
    <a href="{{ route('laporan-transaksi.index') }}" class="btn btn-primary mt-3">Kembali ke Daftar Transaksi</a>
</div>
@endsection
