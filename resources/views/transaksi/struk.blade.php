@extends('layouts.app')

@section('title', 'Struk Transaksi')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white text-center">
        <h2>Struk Transaksi</h2>
    </div>
    <div class="card-body">
        <!-- Tampilkan nama toko, alamat, dan nomor telepon -->
        <p><strong>Toko:</strong> {{ $toko->nama_toko ?? 'Toko tidak ditemukan' }}</p>
        <p><strong>Alamat:</strong> {{ $toko->alamat ?? 'Alamat tidak tersedia' }}</p>
        <p><strong>Telepon:</strong> {{ $toko->no_telepon ?? 'Nomor telepon tidak tersedia' }}</p>

        <p><strong>Nomor Transaksi:</strong> {{ $transaksi->nomor_transaksi }}</p>
        <p><strong>Waktu:</strong> {{ $transaksi->created_at }}</p>
        <p><strong>Staff:</strong> {{ optional($transaksi->staff)->nama_staff ?? 'Staff tidak tersedia' }}</p>
        
        <h3 class="mt-4">Detail Belanja:</h3>
        <table class="table table-bordered">
            <thead class="table-secondary">
                <tr>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksi->detailTransaksi as $detail)
                    <tr>
                        <td>{{ optional($detail->produk)->nama_produk ?? 'Produk tidak tersedia' }}</td>
                        <td>{{ $detail->jumlah }}</td>
                        <td>{{ number_format($detail->subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Tampilkan total, diskon, jumlah bayar, dan kembalian -->
        <h3>Total Belanja: {{ number_format($total, 2) }}</h3>
        <p><strong>Diskon:</strong> {{ optional($transaksi->diskon)->jumlah_diskon ?? 0 }}%</p>
        <p><strong>Jumlah Bayar:</strong> {{ number_format($transaksi->jumlah_bayar, 2) }}</p>
        <p><strong>Kembalian:</strong> {{ number_format($transaksi->kembalian, 2) }}</p>
    </div>
    <div class="card-footer text-center">
        <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection
