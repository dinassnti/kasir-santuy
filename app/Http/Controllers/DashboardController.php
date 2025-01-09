<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Staff;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahProduk = Produk::count();
        $jumlahTransaksi = Transaksi::count();
        $jumlahStaff = Staff::count();
        $transaksiTerbaru = Transaksi::latest()->take(5)->get();
        $totalPendapatan = Transaksi::sum('jumlah_bayar');

        // Kirim data ke view
        return view('dashboard', compact('jumlahProduk', 'jumlahTransaksi', 'jumlahStaff', 'transaksiTerbaru', 'totalPendapatan'));
    }
}


