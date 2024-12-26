@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Profil Toko</h3>
                </div>
                <div class="card-body">
                    {{-- Pesan Sukses --}}
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    {{-- Pesan Error --}}
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    {{-- Form Profil Toko --}}
                    <form action="{{ $toko ? route('toko.update') : route('toko.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-4">
                            {{-- Foto Toko --}}
                            <div class="col-md-4 text-center">
                                <label for="foto_toko" class="form-label">Foto Toko</label>
                                <div class="mb-3">
                                    @if($toko && $toko->foto_toko)
                                        <img src="{{ asset('storage/' . $toko->foto_toko) }}" alt="Foto Toko" class="rounded img-thumbnail" style="width: 150px; height: 150px;">
                                    @else
                                        <img src="https://via.placeholder.com/150" alt="Foto Toko" class="rounded img-thumbnail" style="width: 150px; height: 150px;">
                                    @endif
                                </div>
                                <input type="file" name="foto_toko" id="foto_toko" class="form-control">
                            </div>

                            {{-- Informasi Toko --}}
                            <div class="col-md-8">
                                {{-- Jenis Usaha --}}
                                <div class="mb-3">
                                    <label for="jenis_usaha" class="form-label">Jenis Usaha</label>
                                    <input type="text" name="jenis_usaha" id="jenis_usaha" class="form-control" 
                                           value="{{ $toko->jenis_usaha ?? '' }}" required>
                                </div>

                                {{-- Nama Toko --}}
                                <div class="mb-3">
                                    <label for="nama_toko" class="form-label">Nama Toko</label>
                                    <input type="text" name="nama_toko" id="nama_toko" class="form-control" 
                                           value="{{ $toko->nama_toko ?? '' }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Email --}}
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" 
                                       value="{{ $toko->email ?? '' }}" required>
                            </div>

                            {{-- No Telepon --}}
                            <div class="col-md-6 mb-3">
                                <label for="no_telepon" class="form-label">No Telepon</label>
                                <input type="text" name="no_telepon" id="no_telepon" class="form-control" 
                                       value="{{ $toko->no_telepon ?? '' }}" required>
                            </div>
                        </div>

                        {{-- Alamat --}}
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea name="alamat" id="alamat" class="form-control" rows="3" required>{{ $toko->alamat ?? '' }}</textarea>
                        </div>

                        {{-- Tombol Simpan --}}
                        <div class="text-end">
                            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                            <button type="submit" class="btn btn-success mt-3">
                                <i class="fas fa-save"></i> {{ $toko ? 'Perbarui' : 'Simpan' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
