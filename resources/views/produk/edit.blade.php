@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <!-- Ubah warna header menjadi biru -->
        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0">Edit Produk</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('produk.update', $produk->id_produk) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Foto Produk -->
                <div class="mb-3">
                    <label for="foto" class="form-label fw-bold">Foto Produk</label>
                    @if ($produk->foto)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama_produk }}" class="img-thumbnail" style="width: 150px;">
                        </div>
                    @endif
                    <input type="file" name="foto" id="foto" class="form-control">
                    @error('foto')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Nama Produk -->
                <div class="mb-3">
                    <label for="nama_produk" class="form-label fw-bold">Nama Produk</label>
                    <input type="text" name="nama_produk" id="nama_produk" class="form-control" value="{{ $produk->nama_produk }}" required>
                    @error('nama_produk')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Kode Barang -->
                <div class="mb-3">
                    <label for="kode_barang" class="form-label fw-bold">Kode Barang</label>
                    <input type="text" name="kode_barang" id="kode_barang" class="form-control" value="{{ $produk->kode_barang }}" required>
                    @error('kode_barang')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Harga Dasar -->
                <div class="mb-3">
                    <label for="harga_dasar" class="form-label fw-bold">Harga Dasar</label>
                    <input type="number" name="harga_dasar" id="harga_dasar" class="form-control" value="{{ $produk->harga_dasar }}" required>
                    @error('harga_dasar')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Harga Jual -->
                <div class="mb-3">
                    <label for="harga_jual" class="form-label fw-bold">Harga Jual</label>
                    <input type="number" name="harga_jual" id="harga_jual" class="form-control" value="{{ $produk->harga_jual }}" required>
                    @error('harga_jual')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Stok -->
                <div class="mb-3">
                    <label for="stok" class="form-label fw-bold">Stok</label>
                    <input type="text" name="stok" class="form-control shadow-sm @error('stok') is-invalid @enderror" value="{{ old('stok', $produk->stok) }}" required readonly>
                </div>
                
                <!-- Kategori -->
                <div class="mb-3">
                    <label for="id_kategori" class="form-label fw-bold">Kategori</label>
                    <select name="id_kategori" id="id_kategori" class="form-select" required>
                        <option value="" disabled>Pilih Kategori</option>
                        @foreach ($kategori as $item)
                            <option value="{{ $item->id_kategori }}" {{ $item->id_kategori == $produk->id_kategori ? 'selected' : '' }}>
                                {{ $item->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_kategori')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Tombol Simpan -->
                <div class="text-end">
                    <!-- Ubah tombol simpan menjadi biru -->
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Perbarui
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
