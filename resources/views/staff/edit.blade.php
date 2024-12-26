@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="h3 mb-3">Edit Data Staff</h1>

    <form action="{{ route('staff.update', $staff->id_staff) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Nama Staff -->
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Staff</label>
            <input type="text" name="nama" id="nama" class="form-control shadow-sm @error('nama') is-invalid @enderror" value="{{ old('nama', $staff->nama) }}" required>
            @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email (Readonly) -->
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="text" name="email" class="form-control shadow-sm @error('email') is-invalid @enderror" value="{{ old('email', $staff->email) }}" required readonly>
        </div>

        <!-- Nomor Telepon -->
        <div class="mb-3">
            <label for="no_telepon" class="form-label">Nomor Telepon</label>
            <input type="text" name="no_telepon" id="no_telepon" class="form-control shadow-sm @error('no_telepon') is-invalid @enderror" value="{{ old('no_telepon', $staff->no_telepon) }}" required>
            @error('no_telepon')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Alamat -->
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea name="alamat" id="alamat" class="form-control shadow-sm @error('alamat') is-invalid @enderror" rows="4" required>{{ old('alamat', $staff->alamat) }}</textarea>
            @error('alamat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Tombol Simpan -->
        <div class="text-end">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Perbarui
            </button>
        </div>
    </form>
</div>
@endsection
