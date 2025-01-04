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
        // Ambil data jumlah produk dan pelanggan
        $user = Auth::user();
        $staff = $user->staff;
        $jumlahProduk = Produk::count();
        $jumlahTransaksi = Transaksi::count();
        // $jumlahPelanggan = Pelanggan::count();
        
        // Kirim data ke view
        return view('dashboard', compact('jumlahProduk', 'jumlahTransaksi', 'user', 'staff'));
    }

    public function dashboard()
    {
        $user = Auth::user(); // Data dari tabel users
        $staff = Staff::where('email', $user->email)->first(); // Ambil data dari tabel data_staff

        return view('dashboard', [
            'nama' => $staff ? $staff->name : 'Admin', // Nama untuk staff, default Admin
            'role' => $user->role,
        ]);
    }
}


