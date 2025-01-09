<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Produk;
use App\Models\Diskon;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        // Mengambil daftar produk, diskon, dan toko
        $produkList = Produk::all();
        $diskonList = Diskon::all();
        $toko = Toko::first();
    
        // Mengambil transaksi terakhir untuk mendapatkan ID terbaru
        $lastTransaksi = Transaksi::latest()->first();
        $idTransaksi = $lastTransaksi ? $lastTransaksi->id + 1 : 1;
    
        return view('transaksi.index', compact('produkList', 'diskonList', 'toko', 'idTransaksi'));
    }

    public function store(Request $request)
    {
        // Validasi input dari request
        $request->validate([
            'produk_data' => 'required|json',
            'id_diskon' => 'nullable|exists:diskon,id_diskon',
            'jumlah_bayar' => 'required|numeric|min:0',
        ]);
    
        // Decode data produk dari request
        $produkData = json_decode($request->produk_data, true);
        $produkList = $produkData['produkList'] ?? [];
    
        if (empty($produkList)) {
            return redirect()->back()->withErrors('Daftar produk tidak boleh kosong.');
        }
    
        // Ambil diskon berdasarkan id_diskon
        $diskon = Diskon::find($request->id_diskon);
        $diskonPersen = $diskon ? $diskon->persentase : 0;
    
        $totalAfterDiskon = 0;
    
        // Hitung total setelah diskon
        foreach ($produkList as $produk) {
            $subtotal = $produk['harga_satuan'] * $produk['jumlah'];
            $diskonItem = $subtotal * ($diskonPersen / 100);
            $totalAfterDiskon += $subtotal - $diskonItem;
    
            // Kurangi stok produk setelah transaksi
            $produkModel = Produk::find($produk['id_produk']);
            if ($produkModel) {
                $produkModel->stok -= $produk['jumlah'];
                $produkModel->save();
            }
        }
    
        // Hitung kembalian
        $jumlahBayar = $request->jumlah_bayar;
        $kembalian = $jumlahBayar - $totalAfterDiskon;
    
        if ($kembalian < 0) {
            return redirect()->back()->withErrors('Jumlah bayar tidak mencukupi.');
        }
    
        // Gunakan transaksi database untuk menyimpan data
        DB::beginTransaction();
        try {
            // Simpan transaksi menggunakan auto-increment ID
            $transaksi = Transaksi::create([
                'id_diskon' => $request->id_diskon,
                'user_id' => Auth::id(), // Menggunakan user_id yang sedang login
                'jumlah_bayar' => $jumlahBayar,
                'kembalian' => $kembalian,
                'total_transaksi' => $totalAfterDiskon,
                'created_at' => now(),
            ]);
    
            // Simpan detail transaksi
            foreach ($produkList as $produk) {
                $transaksi->detailTransaksi()->create([
                    'id_produk' => $produk['id_produk'],
                    'harga_satuan' => $produk['harga_satuan'],
                    'jumlah' => $produk['jumlah'],
                ]);
            }
    
            DB::commit();
    
            // Redirect ke halaman struk dengan pesan sukses
            return redirect()->route('transaksi.struk', ['id' => $transaksi->id])->with('success', 'Transaksi berhasil diproses.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Terjadi kesalahan saat memproses transaksi: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        // Ambil transaksi berdasarkan ID, bersama relasi
        $transaksi = Transaksi::with(['detailTransaksi.produk', 'diskon', 'user'])->findOrFail($id);
    
        // Ambil data toko (pastikan data toko ada di database)
        $toko = Toko::first();
    
        // Hitung total belanja dari detail transaksi
        $total = $transaksi->detailTransaksi->sum(function ($detail) {
            return $detail->harga_satuan * $detail->jumlah;
        });
    
        return view('transaksi.struk', compact('transaksi', 'total', 'toko'));
    }
    
    public function laporanTransaksi(Request $request)
    {
        // Ambil data filter tanggal dari request
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        
        // Query transaksi dengan filter tanggal jika ada
        $query = Transaksi::with(['detailTransaksi.produk', 'diskon', 'user']);
        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }
        
        $transaksiList = $query->get();
        
        return view('laporan-transaksi.index', compact('transaksiList'));
    }
    

    public function detailTransaksi($id)
    {
        // Ambil transaksi dengan detail, produk, user, dan diskon
        $transaksi = Transaksi::with(['detailTransaksi.produk', 'user', 'diskon'])->findOrFail($id); // Tambahkan 'toko' di sini
    
        return view('laporan-transaksi.detail', compact('transaksi'));
    }
}
