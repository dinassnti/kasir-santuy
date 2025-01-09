<?php

namespace App\Http\Controllers;

use App\Models\Diskon;
use Illuminate\Http\Request;

class DiskonController extends Controller
{
    public function index()
    {
        $diskon = Diskon::where('user_id', auth()->id())->get(); 
        return view('diskon.index', compact('diskon'));
    }

    public function create()
    {
        return view('diskon.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_diskon' => 'required|max:50',
            'persentase' => 'required|numeric|min:0|max:100',
            'tanggal_mulai' => 'required|date|before_or_equal:tanggal_berakhir',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        Diskon::create([
            'nama_diskon' => $request->nama_diskon,
            'persentase' => $request->persentase,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_berakhir' => $request->tanggal_berakhir,
            'user_id' => auth()->id(), 
        ]);

        return redirect()->route('diskon.index')->with('success', 'Diskon berhasil ditambahkan.');
    }

    public function edit($id_diskon)
    {
        $diskon = Diskon::findOrFail($id_diskon);
        return view('diskon.edit', compact('diskon'));
    }

    public function update(Request $request, $id_diskon)
    {
        $request->validate([
            'nama_diskon' => 'required|max:50',
            'persentase' => 'required|numeric|min:0|max:100',
            'tanggal_mulai' => 'required|date|before_or_equal:tanggal_berakhir',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $diskon = Diskon::findOrFail($id_diskon);
        $diskon->update($request->only(['nama_diskon', 'persentase', 'tanggal_mulai', 'tanggal_berakhir']));

        return redirect()->route('diskon.index')->with('success', 'Diskon berhasil diperbarui.');
    }

    public function destroy($id_diskon)
    {
        $diskon = Diskon::findOrFail($id_diskon);
        $diskon->delete();

        return redirect()->route('diskon.index')->with('success', 'Diskon berhasil dihapus.');
    }
}
