@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0">Tambah Produk</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Foto Produk -->
                <div class="mb-3">
                    <label for="foto" class="form-label fw-bold">Foto Produk</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                    @error('foto')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Nama Produk -->
                <div class="mb-3">
                    <label for="nama_produk" class="form-label fw-bold">Nama Produk</label>
                    <input type="text" name="nama_produk" id="nama_produk" class="form-control" placeholder="Masukkan nama produk" required>
                    @error('nama_produk')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Kode Barang -->
                <div class="mb-3">
                    <label for="kode_barang" class="form-label fw-bold">Kode Barang</label>
                    <input type="text" name="kode_barang" id="kode_barang" class="form-control" placeholder="Masukkan kode barang" required>
                    @error('kode_barang')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Harga Dasar -->
                <div class="mb-3">
                    <label for="harga_dasar" class="form-label fw-bold">Harga Dasar</label>
                    <input type="number" name="harga_dasar" id="harga_dasar" class="form-control" placeholder="Masukkan harga dasar" required>
                    @error('harga_dasar')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Harga Jual -->
                <div class="mb-3">
                    <label for="harga_jual" class="form-label fw-bold">Harga Jual</label>
                    <input type="number" name="harga_jual" id="harga_jual" class="form-control" placeholder="Masukkan harga jual" required>
                    @error('harga_jual')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Stok -->
                <div class="mb-3">
                    <label for="stok" class="form-label fw-bold">Stok</label>
                    <input type="number" name="stok" id="stok" class="form-control" placeholder="Masukkan jumlah stok" required>
                    @error('stok')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Kategori -->
                <div class="mb-3">
                    <label for="id_kategori" class="form-label fw-bold">Kategori</label>
                    <select name="id_kategori" id="id_kategori" class="form-select" required>
                        <option value="" disabled selected>Pilih Kategori</option>
                        @foreach ($kategori as $item)
                            <option value="{{ $item->id_kategori }}">{{ $item->nama_kategori }}</option>
                        @endforeach
                    </select>
                    @error('id_kategori')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Tombol Simpan -->
                <div class="text-end">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
