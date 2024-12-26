<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class StokController extends Controller
{
    public function index()
    {
        // Ambil hanya nama_produk dan stok
        $produk = Produk::select('id_produk', 'nama_produk', 'stok')->get();
        return view('stok.index', compact('produk'));
    }

    public function update(Request $request, $id_produk)
    {
        // Validasi input stok
        $request->validate([
            'stok' => 'required|integer|min:0',
        ]);
    
        // Cari produk berdasarkan ID
        $produk = Produk::findOrFail($id_produk);
    
        // Update stok
        $produk->stok = $request->stok;
        $produk->save();
    
        return redirect()->route('stok.index')->with('success', 'Stok berhasil diperbarui!');
    }
}
