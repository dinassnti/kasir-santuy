<?php

namespace App\Http\Controllers;

use App\Models\Diskon;
use Illuminate\Http\Request;

class DiskonController extends Controller
{
    // Menampilkan daftar diskon
    public function index()
    {
        $diskon = Diskon::where('user_id', auth()->id())->get(); 
        return view('diskon.index', compact('diskon'));
    }

    // Menampilkan form tambah diskon
    public function create()
    {
        return view('diskon.create');
    }

    // Menyimpan diskon baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_diskon' => 'required|max:50',
            'persentase' => 'nullable|numeric|min:0|max:100',
            'nominal' => 'nullable|numeric|min:0',
            'tanggal_mulai' => 'required|date|before_or_equal:tanggal_berakhir',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
            // Validasi untuk memastikan hanya salah satu yang diisi
            'persentase' => 'nullable|numeric|min:0|max:100|required_without:nominal',
            'nominal' => 'nullable|numeric|min:0|required_without:persentase',
        ], [
            'persentase.required_without' => 'Anda harus mengisi salah satu, persentase atau nominal.',
            'nominal.required_without' => 'Anda harus mengisi salah satu, persentase atau nominal.',
        ]);

        // Menyimpan diskon baru dengan user_id
        Diskon::create([
            'nama_diskon' => $request->nama_diskon,
            'persentase' => $request->persentase,
            'nominal' => $request->nominal,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_berakhir' => $request->tanggal_berakhir,
            'user_id' => auth()->id(), // Menyimpan ID user yang sedang login
        ]);

        return redirect()->route('diskon.index')->with('success', 'Diskon berhasil ditambahkan.');
    }

    // Menampilkan form edit diskon
    public function edit($id_diskon)
    {
        $diskon = Diskon::findOrFail($id_diskon);
        return view('diskon.edit', compact('diskon'));
    }

    // Memperbarui diskon
    public function update(Request $request, $id_diskon)
    {
        $request->validate([
            'nama_diskon' => 'required|max:50',
            'persentase' => 'nullable|numeric|min:0|max:100',
            'nominal' => 'nullable|numeric|min:0',
            'tanggal_mulai' => 'required|date|before_or_equal:tanggal_berakhir',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
            // Validasi untuk memastikan hanya salah satu yang diisi
            'persentase' => 'nullable|numeric|min:0|max:100|required_without:nominal',
            'nominal' => 'nullable|numeric|min:0|required_without:persentase',
        ], [
            'persentase.required_without' => 'Anda harus mengisi salah satu, persentase atau nominal.',
            'nominal.required_without' => 'Anda harus mengisi salah satu, persentase atau nominal.',
        ]);

        $diskon = Diskon::findOrFail($id_diskon);
        $diskon->update($request->all());

        return redirect()->route('diskon.index')->with('success', 'Diskon berhasil diperbarui.');
    }

    // Menghapus diskon
    public function destroy($id_diskon)
    {
        $diskon = Diskon::findOrFail($id_diskon);
        $diskon->delete();

        return redirect()->route('diskon.index')->with('success', 'Diskon berhasil dihapus.');
    }
}