@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="h3 mb-4">Tambah Staff</h1>

    <!-- Menampilkan informasi pengguna yang sedang login -->
    <div class="alert alert-info shadow-sm mb-4">
        <strong>Nama User:</strong> {{ Auth::user()->nama ?? 'Pengguna tidak dikenal' }}
    </div>

    <form action="{{ route('staff.store') }}" method="POST">
        @csrf
        <!-- Input Nama -->
        <div class="mb-4">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" name="nama" id="nama" class="form-control shadow-sm @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
            @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Input Email -->
        <div class="mb-4">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control shadow-sm @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Input Nomor Telepon -->
        <div class="mb-4">
            <label for="no_telepon" class="form-label">Nomor Telepon</label>
            <input type="text" name="no_telepon" id="no_telepon" class="form-control shadow-sm @error('no_telepon') is-invalid @enderror" value="{{ old('no_telepon') }}" required>
            @error('no_telepon')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Input Alamat -->
        <div class="mb-4">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea name="alamat" id="alamat" class="form-control shadow-sm @error('alamat') is-invalid @enderror" rows="4" required>{{ old('alamat') }}</textarea>
            @error('alamat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Input Password -->
        <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control shadow-sm @error('password') is-invalid @enderror" required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Pilihan Status Aktif -->
        <div class="mb-4">
            <label for="status_aktif" class="form-label">Status Aktif</label>
            <select name="status_aktif" id="status_aktif" class="form-control shadow-sm @error('status_aktif') is-invalid @enderror" required>
                <option value="1" {{ old('status_aktif') == '1' ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ old('status_aktif') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
            @error('status_aktif')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Tombol Simpan -->
        <div class="text-end">
            <button type="submit" class="btn btn-primary btn-lg shadow-sm hover-shadow-lg">Simpan</button>
        </div>
    </form>
</div>
@endsection

@section('styles')
<style>
    .form-control {
        transition: all 0.3s ease-in-out;
    }
    .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.5);
        border-color: #268fff;
    }

    .btn:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transform: translateY(-2px);
    }

    .hover-shadow-lg:hover {
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }

    .invalid-feedback {
        font-size: 0.875rem;
        margin-top: 5px;
    }

    .container {
        background-color: #f9f9f9;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
</style>
@endsection
