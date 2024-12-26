@extends('layouts.app')

@section('title', 'Tambah Diskon')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary">Tambah Diskon</h1>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Form Tambah Diskon</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('diskon.store') }}" method="POST">
                @csrf

                <!-- Nama Diskon -->
                <div class="mb-3">
                    <label for="nama_diskon" class="form-label">Nama Diskon</label>
                    <input type="text" class="form-control @error('nama_diskon') is-invalid @enderror" id="nama_diskon" name="nama_diskon" value="{{ old('nama_diskon') }}" required>
                    @error('nama_diskon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Pilih Jenis Diskon -->
                <div class="mb-3">
                    <label for="jenis_diskon" class="form-label">Jenis Diskon</label>
                    <select class="form-select @error('jenis_diskon') is-invalid @enderror" id="jenis_diskon" name="jenis_diskon" onchange="toggleDiskonInput()" required>
                        <option value="" disabled selected>Pilih Jenis Diskon</option>
                        <option value="persentase" {{ old('jenis_diskon') == 'persentase' ? 'selected' : '' }}>Persentase</option>
                        <option value="nominal" {{ old('jenis_diskon') == 'nominal' ? 'selected' : '' }}>Nominal</option>
                    </select>
                    @error('jenis_diskon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Input Persentase -->
                <div class="mb-3 hidden" id="persentase_field">
                    <label for="persentase" class="form-label">Persentase (%)</label>
                    <input type="number" class="form-control @error('persentase') is-invalid @enderror" id="persentase" name="persentase" value="{{ old('persentase') }}" step="0.01" min="0" max="100" placeholder="Masukkan persentase diskon">
                    @error('persentase')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Input Nominal -->
                <div class="mb-3 hidden" id="nominal_field">
                    <label for="nominal" class="form-label">Nominal (Rp)</label>
                    <input type="number" class="form-control @error('nominal') is-invalid @enderror" id="nominal" name="nominal" value="{{ old('nominal') }}" step="0.01" min="0" placeholder="Masukkan nominal diskon">
                    @error('nominal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tanggal Mulai -->
                <div class="mb-3">
                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                    <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required>
                    @error('tanggal_mulai')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tanggal Berakhir -->
                <div class="mb-3">
                    <label for="tanggal_berakhir" class="form-label">Tanggal Berakhir</label>
                    <input type="date" class="form-control @error('tanggal_berakhir') is-invalid @enderror" id="tanggal_berakhir" name="tanggal_berakhir" value="{{ old('tanggal_berakhir') }}" required>
                    @error('tanggal_berakhir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit -->
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Simpan Diskon</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script untuk toggle field diskon -->
<script>
    function toggleDiskonInput() {
        const jenisDiskon = document.getElementById('jenis_diskon').value;
        const persentaseField = document.getElementById('persentase_field');
        const nominalField = document.getElementById('nominal_field');

        persentaseField.classList.toggle('hidden', jenisDiskon !== 'persentase');
        nominalField.classList.toggle('hidden', jenisDiskon !== 'nominal');
    }

    // Mengatur kondisi saat halaman reload
    document.addEventListener('DOMContentLoaded', toggleDiskonInput);
</script>

<!-- Styling CSS untuk menyembunyikan elemen -->
<style>
    .hidden {
        display: none;
    }
</style>
@endsection
