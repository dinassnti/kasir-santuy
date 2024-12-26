@extends('layouts.app')

@section('title', 'Daftar Diskon')

@section('content')
<div class="container mt-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary">Daftar Diskon</h1>
        <!-- Add Discount Button -->
        <a href="{{ route('diskon.create') }}" class="btn btn-success shadow-sm">
            <i class="bi bi-plus-circle"></i> Tambah Diskon
        </a>
    </div>

    <!-- Table Section -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Diskon Tersedia</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%">No</th>
                            <th>Nama Diskon</th>
                            <th>Persentase</th>
                            <th>Nominal</th>
                            <th>Periode</th>
                            <th style="width: 20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($diskon as $d)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $d->nama_diskon }}</td>
                            <td>{{ $d->persentase ? $d->persentase . '%' : '-' }}</td>
                            <td>{{ $d->nominal ? 'Rp' . number_format($d->nominal, 0, ',', '.') : '-' }}</td>
                            <td>{{ $d->tanggal_mulai }} / {{ $d->tanggal_berakhir }}</td>
                            <td>
                                <a href="{{ route('diskon.edit', $d->id_diskon) }}" class="btn btn-warning btn-sm me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Diskon">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('diskon.destroy', $d->id_diskon) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus diskon ini?')" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Diskon">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada diskon yang tersedia.</td>
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
