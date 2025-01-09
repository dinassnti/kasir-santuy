@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">Laporan Transaksi</h2>
    
    <!-- Filter Form -->
    <form method="GET" action="{{ route('laporan-transaksi.index') }}" class="card p-4 mb-4 shadow-sm">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="start_date" class="form-label fw-semibold">Tanggal Mulai</label>
                <input type="date" class="form-control" name="start_date" id="start_date" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="end_date" class="form-label fw-semibold">Tanggal Selesai</label>
                <input type="date" class="form-control" name="end_date" id="end_date" value="{{ request('end_date') }}">
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-filter"></i> Terapkan Filter
            </button>
        </div>
    </form>

    <!-- Transaksi Table -->
    @if ($transaksiList->isEmpty())
        <div class="alert alert-info text-center" role="alert">
            <i class="bi bi-exclamation-circle"></i> Belum ada transaksi yang tercatat.
        </div>
    @else
        <table class="table table-hover table-bordered shadow-sm">
            <thead class="table-primary text-center">
                <tr>
                    <th>ID Transaksi</th>
                    <th>Kasir</th>
                    <th>Tanggal</th>
                    <th>Total Belanja</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksiList as $transaksi)
                    <tr>
                        <td>{{ $transaksi->id_transaksi }}</td>
                        <td>{{ $transaksi->user ? $transaksi->user->nama : 'Tidak Ada Staff' }}</td>
                        <td>{{ $transaksi->created_at->isToday() ? now()->format('d/m/Y') : $transaksi->created_at->format('d/m/Y') }}</td>
                        <td class="text-end">Rp {{ number_format($transaksi->detailTransaksi->sum('subtotal'), 2, ',', '.') }}</td>
                        <td class="text-center">
                            <a href="{{ route('laporan-transaksi.detail', $transaksi->id_transaksi) }}" class="btn btn-info btn-sm">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
