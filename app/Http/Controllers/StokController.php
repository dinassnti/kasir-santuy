<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class StokController extends Controller
{
    public function index()
    {
        $produk = Produk::select('id_produk', 'nama_produk', 'stok')->get();
        return view('stok.index', compact('produk'));
    }

    public function update(Request $request, $id_produk)
    {
        $request->validate([
            'stok' => 'required|integer|min:0',
        ]);
    
        $produk = Produk::findOrFail($id_produk);
        $produk->stok = $request->stok;
        $produk->save();
    
        return redirect()->route('stok.index')->with('success', 'Stok berhasil diperbarui!');
    }
}
