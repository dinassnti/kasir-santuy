<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::all(); 
        return view('kategori.index', compact('kategoris')); 
    }

    public function create()
    {
        return view('kategori.create'); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|unique:kategori,nama_kategori|max:255',
            'deskripsi' => 'nullable|max:1000', 
        ]);
    
        Kategori::create([
            'nama_kategori' => $request->input('nama_kategori'),
            'deskripsi' => $request->input('deskripsi'), 
        ]);
    
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil disimpan');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id); 
        $kategori->delete(); 

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus');
    }
}
