@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h1 class="card-title mb-0">Transaksi</h1>
        </div>
        <div class="card-body">

            {{-- Informasi Toko --}}
            <div class="card mb-3">
                <div class="card-body">
                    @if($toko)
                        <h5 class="card-title">{{ $toko->nama_toko }}</h5>
                        <p class="card-text">
                            Alamat: {{ $toko->alamat }}<br>
                            Telepon: {{ $toko->no_telepon }}
                        </p>
                    @else
                        <p>Toko tidak ditemukan.</p>
                    @endif
                </div>
            </div>

            {{-- Pesan Sukses --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- Pesan Error --}}
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form Input Produk --}}
            <form id="transaksiForm" class="mb-4">
                @csrf

                <div class="row">
                {{-- Nama Staff --}}
                <div class="form-group">
                    <label for="nama_staff">Nama Staff</label>
                    <input type="text" id="nama_staff" class="form-control" value="{{ Auth::user()->staff->nama ?? 'Staff tidak ditemukan' }}" readonly>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="nomor_transaksi">Nomor Transaksi</label>
                        <input type="text" id="nomor_transaksi" class="form-control" value="{{ old('nomor_transaksi', 'TRX-' . now()->format('Ymd') . '-001') }}" readonly>
                    </div>
                </div>
                    {{-- Pilih Produk --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_produk">Produk</label>
                            <select name="id_produk" id="id_produk" class="form-control" required>
                                <option value="">Pilih Produk</option>
                                @foreach($produkList as $produk)
                                    <option value="{{ $produk->id_produk }}" data-harga="{{ $produk->harga_jual }}">
                                        {{ $produk->nama_produk }} - Rp{{ number_format($produk->harga_jual, 2) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Jumlah Produk --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="jumlah">Jumlah</label>
                            <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" value="1" required>
                        </div>
                    </div>

                    {{-- Tombol Tambah --}}
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-primary w-100" id="tambahProduk">
                            <i class="bi bi-plus-lg"></i> Tambah
                        </button>
                    </div>
                </div>
            </form>

            <hr>

            {{-- Tabel Produk --}}
            <h3>Daftar Produk</h3>
            <table class="table table-bordered table-striped table-hover" id="produkTable">
                <thead class="thead-dark">
                    <tr>
                        <th>Nama Produk</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

            {{-- Total & Jumlah Bayar --}}
            <form action="{{ route('transaksi.store') }}" method="POST" class="mt-4">
                @csrf
                <input type="hidden" name="produk_data" id="produk_data">

                <div class="form-row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="total">Total</label>
                            <input type="text" id="total" class="form-control" readonly>
                        </div>
                    </div>

                    {{-- Pilih Diskon --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="id_diskon">Diskon</label>
                            <select name="id_diskon" id="id_diskon" class="form-control">
                                <option value="" data-diskon="0">Tidak Ada Diskon</option>
                                @foreach($diskonList as $diskon)
                                    <option value="{{ $diskon->id_diskon }}" data-diskon="{{ $diskon->persentase }}">
                                        {{ $diskon->nama_diskon }} - {{ $diskon->persentase }}%
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="jumlah_bayar">Jumlah Bayar</label>
                            <input type="number" name="jumlah_bayar" id="jumlah_bayar" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="kembalian">Kembalian</label>
                            <input type="text" id="kembalian" class="form-control" readonly>
                        </div>
                    </div>
                </div>

                {{-- Tombol Proses --}}
                <button type="submit" class="btn btn-success btn-block mt-3">
                    <i class="bi bi-check-circle"></i> Proses Transaksi
                </button>
            </form>
        </div>
    </div>
</div>

{{-- Script --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let produkList = []; // Menyimpan daftar produk sementara
        const produkTable = document.querySelector('#produkTable tbody');
        const totalInput = document.getElementById('total');
        const kembalianInput = document.getElementById('kembalian');
        const jumlahBayarInput = document.getElementById('jumlah_bayar');
        const produkDataInput = document.getElementById('produk_data');
        const diskonSelect = document.getElementById('id_diskon');

        // Tambahkan Produk ke Daftar
        document.getElementById('tambahProduk').addEventListener('click', function () {
            const idProduk = document.getElementById('id_produk').value;
            const selectedOption = document.querySelector(`#id_produk option[value="${idProduk}"]`);
            const namaProduk = selectedOption ? selectedOption.textContent.split(' - ')[0] : null;
            const hargaSatuan = selectedOption ? parseFloat(selectedOption.dataset.harga) : null;
            const jumlah = parseInt(document.getElementById('jumlah').value);

            if (!idProduk || jumlah < 1 || !hargaSatuan) {
                alert('Pilih produk dan jumlah dengan benar.');
                return;
            }

            const subtotal = hargaSatuan * jumlah;

            // Tambahkan ke daftar produk
            produkList.push({ id_produk: idProduk, nama_produk: namaProduk, harga_satuan: hargaSatuan, jumlah, subtotal });
            renderTable();

            // Reset form
            document.getElementById('id_produk').value = '';
            document.getElementById('jumlah').value = 1;
        });

        // Render Tabel Produk
        function renderTable() {
            produkTable.innerHTML = '';
            let total = 0;

            produkList.forEach((produk, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${produk.nama_produk}</td>
                    <td>Rp${produk.harga_satuan.toLocaleString()}</td>
                    <td>${produk.jumlah}</td>
                    <td>Rp${produk.subtotal.toLocaleString()}</td>
                    <td><button class="btn btn-danger btn-sm" onclick="hapusProduk(${index})">Hapus</button></td>
                `;
                produkTable.appendChild(row);
                total += produk.subtotal;
            });

            // Terapkan diskon
            const diskonOption = diskonSelect.options[diskonSelect.selectedIndex];
            const diskon = parseFloat(diskonOption.dataset.diskon) || 0;
            const totalDiskon = total * (diskon / 100);
            const totalAfterDiskon = total - totalDiskon;

            totalInput.value = `Rp${totalAfterDiskon.toLocaleString()}`;
            produkDataInput.value = JSON.stringify({ produkList, diskon, totalAfterDiskon });
        }

        // Hapus Produk dari Daftar
        window.hapusProduk = function (index) {
            produkList.splice(index, 1);
            renderTable();
        };

        // Hitung Total ketika Diskon Berubah
        diskonSelect.addEventListener('change', function () {
            renderTable();
        });

        // Hitung Kembalian
        jumlahBayarInput.addEventListener('input', function () {
            const total = produkList.reduce((sum, produk) => sum + produk.subtotal, 0);
            const diskon = parseFloat(diskonSelect.options[diskonSelect.selectedIndex].dataset.diskon) || 0;
            const totalAfterDiskon = total - (total * (diskon / 100));

            const jumlahBayar = parseFloat(jumlahBayarInput.value) || 0;
            const kembalian = jumlahBayar - totalAfterDiskon;
            kembalianInput.value = kembalian >= 0 ? `Rp${kembalian.toLocaleString()}` : 'Rp0';
        });
    });
</script>
@endsection
