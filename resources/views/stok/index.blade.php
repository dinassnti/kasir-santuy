@extends('layouts.app')

@section('title', 'Kelola Stok Barang')

@section('content')
<div class="container mt-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary">Kelola Stok Barang</h1>
        <!-- Search Form -->
        <form action="{{ route('stok.index') }}" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari produk..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary shadow-sm">
                <i class="bi bi-search"></i> Cari
            </button>
        </form>
    </div>

    <!-- Table Section -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Stok Barang Tersedia</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%">No</th>
                            <th>Nama Produk</th>
                            <th style="width: 20%">Stok</th>
                            <th style="width: 20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($produk as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_produk }}</td>
                                <td>{{ $item->stok }}</td>
                                <td>
                                    <!-- Form untuk Update Stok -->
                                    <form action="{{ route('stok.update', $item->id_produk) }}" method="POST">
                                        @csrf
                                        <div class="input-group">
                                            <input type="number" name="stok" class="form-control" value="{{ $item->stok }}" min="0" required>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Tidak ada data produk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Initialize Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush
