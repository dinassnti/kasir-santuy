<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::with('kategori')->get(); // Mengambil produk beserta kategori
        return view('produk.index', compact('produk'));
    }

    public function create()
    {
        $kategori = Kategori::all();
    
        return view('produk.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'kode_barang' => 'required|unique:produk,kode_barang|max:100',
            'nama_produk' => 'required|string|max:255',
            'harga_dasar' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0|gte:harga_dasar',
            'stok' => 'required|integer|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        $produk = Produk::create([
            'id_kategori' => $request->id_kategori,
            'nama_produk' => $request->nama_produk,
            'kode_barang' => $request->kode_barang,
            'harga_dasar' => $request->harga_dasar,
            'harga_jual' => $request->harga_jual,
            'stok' => $request->stok,
            'user_id' => auth()->id(), 
        ]);
    
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
    
            $produk->foto = $filename;
            $produk->save(); 
        }

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $kategori = Kategori::all();
        
        return view('produk.edit', compact('produk', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'kode_barang' => 'required|string|max:50|unique:produk,kode_barang,' . $id . ',id_produk',
            'nama_produk' => 'required|string|max:255',
            'harga_dasar' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0|gte:harga_dasar',
            'stok' => 'required|numeric|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:10048',
        ]);
    
        $produk = Produk::findOrFail($id);

        $produk->id_kategori = $validated['id_kategori'];
        $produk->kode_barang = $validated['kode_barang'];
        $produk->nama_produk = $validated['nama_produk'];
        $produk->harga_dasar = $validated['harga_dasar'];
        $produk->harga_jual = $validated['harga_jual'];
        $produk->stok = $validated['stok'];
    
        if ($request->hasFile('foto')) {
            if ($produk->foto && file_exists(public_path('uploads/' . $produk->foto))) {
                unlink(public_path('uploads/' . $produk->foto));
            }
    
            //foto baru
            $file = $request->file('foto');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $produk->foto = $filename;
        }
    
        $produk->save();
    
        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');
    }


    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();
    
        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus');
    }
}
