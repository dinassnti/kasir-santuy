@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
<div class="container mt-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary">Daftar Produk</h1>
        <!-- Search Form -->
        <form action="{{ route('produk.index') }}" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari produk..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary shadow-sm">
                <i class="bi bi-search"></i> Cari
            </button>
        </form>
    </div>
    <!-- Add Product Button -->
    <div class="mt-4 d-flex justify-content-start">
        <a href="{{ route('produk.create') }}" class="btn btn-success shadow-sm">
            <i class="bi bi-plus-circle"></i> Tambah Produk
        </a>
    </div>

    <!-- Table Section -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Produk Tersedia</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 10%">Foto</th>
                            <th>Kode Barang</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th style="width: 15%">Harga Dasar</th>
                            <th style="width: 15%">Harga Jual</th>
                            <th style="width: 10%">Stok</th>
                            <th style="width: 20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($produk as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if ($item->foto && file_exists(public_path('uploads/' . $item->foto)))
                                        <!-- Menampilkan foto produk -->
                                        <img src="{{ asset('uploads/' . $item->foto) }}" alt="{{ $item->nama_produk }}" class="img-thumbnail" style="width: 80px; height: 80px;">
                                    @else
                                        <!-- Fallback jika foto tidak ada -->
                                        <div class="d-inline-block bg-secondary text-white rounded-circle text-center" 
                                            style="width: 40px; height: 40px; line-height: 40px; font-size: 18px;">
                                            {{ Str::upper(Str::substr($item->nama_produk, 0, 2)) }}
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $item->kode_barang }}</td>
                                <td>{{ $item->nama_produk }}</td>
                                <td>{{ $item->kategori->nama_kategori ?? 'Tidak Ada Kategori' }}</td>
                                <td>Rp {{ number_format($item->harga_dasar, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                                <td>{{ $item->stok }}</td>
                                <td>
                                    <a href="{{ route('produk.edit', $item->id_produk) }}" class="btn btn-warning btn-sm me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Produk">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('produk.destroy', $item->id_produk) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus produk ini?')" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Produk">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">Tidak ada data produk.</td>
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