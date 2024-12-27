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
        $produkData = json_decode($request->produk_data, true);
        $produkList = $produkData['produkList'];
        $diskon = $produkData['diskon'];
        $totalAfterDiskon = 0; // Initialize total after discount
        
        // Calculate total after discount
        foreach ($produkList as $produk) {
            $subtotal = $produk['subtotal']; // Subtotal per item
            $totalAfterDiskon += $subtotal - ($subtotal * ($diskon / 100)); // Add subtotal after discount
        }
    
        // Calculate change
        $jumlah_bayar = $request->jumlah_bayar;
        $kembalian = $jumlah_bayar - $totalAfterDiskon;
    
        // Save the transaction with the appropriate staff ID
        $transaksi = new Transaksi([
            'id_staff' => auth()->user()->id, // Use the logged-in user's ID
            'id_diskon' => $diskon, // Store the discount ID used
            'jumlah_bayar' => $jumlah_bayar,
            'kembalian' => $kembalian,
        ]);
        $transaksi->save(); // Make sure the transaction is saved first
    
        // Insert the details of the transaction (the products purchased)
        foreach ($produkList as $produk) {
            $transaksi->detailTransaksi()->create([
                'id_produk' => $produk['id_produk'],
                'harga_satuan' => $produk['harga_satuan'],
                'jumlah' => $produk['jumlah'],
                'id_transaksi' => $transaksi->id, // Make sure to associate with the transaction ID
            ]);
        }
    
        // Calculate the total of all subtotals in the detail_transaksi table for the current transaction
        $totalTransaksi = $transaksi->detailTransaksi->sum('subtotal');
    
        // Optionally, you can update the transaction with the total amount if needed
        $transaksi->update([
            'total_transaksi' => $totalTransaksi,
        ]);
    
        return redirect()->route('transaksi.struk')->with('success', 'Transaksi berhasil diproses');
    }

    public function show()
    {
        // Ambil transaksi terakhir yang disimpan dan relasi staff dan detailTransaksi
        $transaksi = Transaksi::with(['staff', 'detailTransaksi.produk'])->latest()->first();
    
        // Ambil data toko tanpa menggunakan foreign key
        $toko = Toko::first();
    
        // Hitung total setelah diskon
        $total = $transaksi->detailTransaksi->sum('subtotal');
    
        return view('transaksi.struk', compact('transaksi', 'toko', 'total'));
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
        $total = $transaksi->detailTransaksi->sum('total');
        
        // Tampilkan detail laporan transaksi
        return view('laporan-transaksi.detail', compact('transaksi', 'total'));
    }
}
