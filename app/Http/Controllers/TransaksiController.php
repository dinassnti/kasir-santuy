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
        $produkList = Produk::all();
        $diskonList = Diskon::all();
        $toko = Toko::first();
    
        $lastTransaction = Transaksi::latest()->first(); 
        $newTransactionId = $lastTransaction ? $lastTransaction->id + 1 : 1; 
    
        return view('transaksi.index', compact('produkList', 'diskonList', 'toko', 'newTransactionId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produk_data' => 'required|json',
            'id_diskon' => 'nullable|exists:diskon,id_diskon',
            'jumlah_bayar' => 'required|numeric|min:0',
        ]);

        $produkData = json_decode($request->produk_data, true);
        $produkList = $produkData['produkList'] ?? [];
    
        if (empty($produkList)) {
            return redirect()->back()->withErrors('Daftar produk tidak boleh kosong.');
        }
    
        $diskon = Diskon::find($request->id_diskon);
        $diskonPersen = $diskon ? $diskon->persentase : 0;
    
        $totalAfterDiskon = 0;

        foreach ($produkList as $produk) {
            $subtotal = $produk['harga_satuan'] * $produk['jumlah'];
            $diskonItem = $subtotal * ($diskonPersen / 100);
            $totalAfterDiskon += $subtotal - $diskonItem;

            $produkModel = Produk::find($produk['id_produk']);
            if ($produkModel) {
                $produkModel->stok -= $produk['jumlah'];
                $produkModel->save();
            }
        }
    
        $jumlahBayar = $request->jumlah_bayar;
        $kembalian = $jumlahBayar - $totalAfterDiskon;
    
        if ($kembalian < 0) {
            return redirect()->back()->withErrors('Jumlah bayar tidak mencukupi.');
        }
    
        DB::beginTransaction();
        try {
            $transaksi = Transaksi::create([
                'id_diskon' => $request->id_diskon,
                'user_id' => Auth::id(), 
                'jumlah_bayar' => $jumlahBayar,
                'kembalian' => $kembalian,
                'total_transaksi' => $totalAfterDiskon,
                'created_at' => now(),
            ]);
    
            foreach ($produkList as $produk) {
                $transaksi->detailTransaksi()->create([
                    'id_produk' => $produk['id_produk'],
                    'harga_satuan' => $produk['harga_satuan'],
                    'jumlah' => $produk['jumlah'],
                ]);
            }
    
            DB::commit();

            return redirect()->route('transaksi.struk', ['id' => $transaksi->id_transaksi])->with('success', 'Transaksi berhasil diproses.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Terjadi kesalahan saat memproses transaksi: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $transaksi = Transaksi::with(['detailTransaksi.produk', 'diskon', 'user'])->findOrFail($id);
        $toko = Toko::first();

        $total = $transaksi->detailTransaksi->sum(function ($detail) {
            return $detail->harga_satuan * $detail->jumlah;
        });
    
        return view('transaksi.struk', compact('transaksi', 'total', 'toko'));
    }
    
    public function laporanTransaksi(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        
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
        $transaksi = Transaksi::with(['detailTransaksi.produk', 'user', 'diskon'])->findOrFail($id); 
    
        return view('laporan-transaksi.detail', compact('transaksi'));
    }
}
