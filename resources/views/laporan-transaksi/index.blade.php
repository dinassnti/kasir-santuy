@extends('layouts.app') <!-- Assuming you have a layout in the 'resources/views/layouts/app.blade.php' -->

@section('content')
<div class="container mt-4">
    <h2>Laporan Transaksi</h2>
    
    <!-- Filter Form -->
    <form method="GET" action="{{ route('laporan-transaksi.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="start_date" class="form-label">Tanggal Mulai</label>
                <input type="date" class="form-control" name="start_date" id="start_date" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="end_date" class="form-label">Tanggal Selesai</label>
                <input type="date" class="form-control" name="end_date" id="end_date" value="{{ request('end_date') }}">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Terapkan Filter</button>
    </form>

    <!-- Transaksi Table -->
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Nomor Transaksi</th>
                <th>Staff</th>
                <th>Tanggal</th>
                <th>Total Belanja</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksiList as $transaksi)
                <tr>
                    <td>{{ $transaksi->nomor_transaksi }}</td>
                    <td>{{ $transaksi->staff ? $transaksi->staff->nama : 'Tidak Ada Staff' }}</td>
                    <td>{{ $transaksi->created_at->format('d/m/Y H:i:s') }}</td>
                    <td>{{ number_format($transaksi->detailTransaksi->sum('subtotal'), 2) }}</td>
                    <td>
                        <a href="{{ route('laporan-transaksi.detail', $transaksi->id_transaksi) }}" class="btn btn-info btn-sm">Detail</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
