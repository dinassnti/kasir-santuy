<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::all(); // Ambil semua data kategori
        return view('kategori.index', compact('kategoris')); // Kirim ke view
    }

    public function create()
    {
        return view('kategori.create'); // Tampilkan form tambah kategori
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|unique:kategori,nama_kategori|max:255',
            'deskripsi' => 'nullable|max:1000', // Deskripsi bersifat nullable dan dapat memiliki maksimal 1000 karakter
        ]);
    
        Kategori::create([
            'nama_kategori' => $request->input('nama_kategori'),
            'deskripsi' => $request->input('deskripsi'), // Deskripsi bisa kosong
        ]);
    
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil disimpan');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id); // Mencari kategori berdasarkan ID
        $kategori->delete(); // Menghapus kategori

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus');
    }
}
