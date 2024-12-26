@extends('layouts.app')

@section('title', 'Kategori Produk')

@section('content')
    <div class="container mt-4">
        <!-- Heading Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-primary">Daftar Kategori</h1>
            <a href="{{ route('kategori.create') }}" class="btn btn-success shadow-sm">
                <i class="bi bi-plus-circle"></i> Tambah Kategori
            </a>
        </div>

        <!-- Alert Section -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Table Section -->
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Kategori Tersedia</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 60%">Nama Kategori</th>
                                <th style="width: 30%">Deskripsi</th>
                                <th style="width: 10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kategoris as $kategori)
                                <tr>
                                    <td class=" text-capitalize">{{ $kategori->nama_kategori }}</td>
                                    <td>{{ $kategori->deskripsi ?: '-' }}</td> <!-- Menampilkan '-' jika deskripsi kosong -->
                                    <td>
                                        <form action="{{ route('kategori.destroy', $kategori->id_kategori) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus kategori ini?')">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Belum ada kategori yang tersedia.</td>
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
