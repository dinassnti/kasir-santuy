<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Produk;
use App\Models\Staff;
use App\Models\Diskon;
use App\Models\Toko;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function index()
    {
        // Mengambil daftar produk, diskon, dan toko
        $produkList = Produk::all();
        $diskonList = Diskon::all();
        $toko = Toko::first();
        $transaksi = Transaksi::all();
        
        // Menampilkan transaksi beserta detail dan diskon
        $transaksi = Transaksi::with(['detailTransaksi', 'diskon', 'staff'])->get();
        
        return view('transaksi.index', compact('produkList', 'diskonList', 'toko', 'transaksi'));
    }

    public function store(Request $request)
    {
        // Ambil id_staff dari pengguna yang sedang login
        $idStaff = auth()->user()->id_staff;  // Pastikan id_staff ada di tabel users

        // Cek apakah id_staff ada, jika tidak, tampilkan error
        if (!$idStaff) {
            return redirect()->back()->withErrors('ID staff tidak ditemukan.');
        }

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
            $subtotal = $produk['harga_satuan'] * $produk['jumlah']; // Hitung subtotal
            $diskonItem = $subtotal * ($diskonPersen / 100); // Hitung diskon
            $totalAfterDiskon += $subtotal - $diskonItem; // Total setelah diskon
        }
    
        // Hitung kembalian
        $jumlahBayar = $request->jumlah_bayar;
        $kembalian = $jumlahBayar - $totalAfterDiskon;
    
        if ($kembalian < 0) {
            return redirect()->back()->withErrors('Jumlah bayar tidak mencukupi.');
        }
    
        // Generate nomor transaksi yang unik
        $nomorTransaksi = 'TRX-' . now()->format('Ymd') . '-' . str_pad(Transaksi::count() + 1, 3, '0', STR_PAD_LEFT);
    
        // Simpan transaksi
        $transaksi = Transaksi::create([
            'nomor_transaksi' => $nomorTransaksi,
            'id_diskon' => $request->id_diskon,
            'id_staff' => $idStaff, // Menggunakan id_staff dari sesi login
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
    
        // Redirect ke halaman struk dengan pesan sukses
        return redirect()->route('transaksi.struk', ['id' => $transaksi->id])->with('success', 'Transaksi berhasil diproses.');
    }    

    public function struk($id)
    {
        // Ambil transaksi beserta detail dan staff yang menginput
        $transaksi = Transaksi::with(['staff', 'detailTransaksi.produk', 'diskon'])->findOrFail($id);
        
        // Hitung total setelah diskon
        $total = $transaksi->detailTransaksi->sum('subtotal');
        
        // Tampilkan struk transaksi
        return view('transaksi.struk', compact('transaksi', 'total'));
    }

    public function laporanTransaksi()
    {
        // Ambil semua transaksi beserta informasi dasar
        $transaksiList = Transaksi::with('staff', 'detailTransaksi')->get();
        
        // Ambil data toko tanpa menggunakan foreign key
        $toko = Toko::first(); // Atau pilih toko lain sesuai kebutuhan
    
        return view('laporan-transaksi.index', compact('transaksiList', 'toko'));
    }
    
    public function detailTransaksi($id)
    {
        // Ambil transaksi beserta detail, produk, staff, dan diskon
        $transaksi = Transaksi::with(['detailTransaksi.produk', 'staff', 'diskon'])->findOrFail($id);
        
        // Hitung total setelah diskon
        $total = $transaksi->detailTransaksi->sum('subtotal');
        
        // Tampilkan detail laporan transaksi
        return view('laporan-transaksi.detail', compact('transaksi', 'total'));
    }    
}

