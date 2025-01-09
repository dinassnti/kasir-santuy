@extends('layouts.app')

@section('title', 'Struk Transaksi')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white text-center">
        <h2>Struk Transaksi</h2>
    </div>
    <div class="card-body">
        <!-- Informasi Toko -->
        <div class="text-center mb-4">
            <p><strong>{{ $toko->nama_toko ?? 'Toko tidak ditemukan' }}</strong></p>
            <p>{{ $toko->alamat ?? 'Alamat tidak tersedia' }}</p>
            <p>{{ $toko->no_telepon ?? 'Nomor telepon tidak tersedia' }}</p>
        </div>

        <!-- Informasi Transaksi -->
        <p><strong>ID Transaksi:</strong> {{ $transaksi->id_transaksi }}</p>
        <p><strong>Tanggal:</strong> {{ $transaksi->created_at->format('d-m-Y H:i:s') }}</p>
        <p><strong>Kasir:</strong> {{ $transaksi->user->nama ?? 'Staff tidak ditemukan' }}</p>

        <!-- Detail Belanja -->
        <h3 class="mt-4">Detail Belanja:</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($transaksi->detailTransaksi) && $transaksi->detailTransaksi->count() > 0)
                    @foreach ($transaksi->detailTransaksi as $detail)
                    <tr>
                        <td>{{ $detail->produk->nama_produk ?? 'Produk tidak ditemukan' }}</td>
                        <td>{{ $detail->jumlah }}</td>
                        <td>Rp {{ number_format($detail->harga_satuan, 2) }}</td>
                        <td>Rp {{ number_format($detail->harga_satuan * $detail->jumlah, 2) }}</td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="text-center">Detail transaksi tidak tersedia</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <!-- Ringkasan Belanja -->
        <h4 class="mt-4">Total Belanja: Rp {{ number_format($total, 2) }}</h4>
        <p><strong>Diskon:</strong> {{ $transaksi->diskon->persentase ?? 0 }}%</p>
        <p><strong>Jumlah Bayar:</strong> Rp {{ number_format($transaksi->jumlah_bayar, 2) }}</p>
        <p><strong>Kembalian:</strong> Rp {{ number_format($transaksi->kembalian, 2) }}</p>
    </div>

    <div class="card-footer text-center">
        <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection
