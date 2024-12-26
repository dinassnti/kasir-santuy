<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index()
    {
        $staff = Staff::all();
        return view('staff.index', compact('staff'));
    }

    public function create()
    {
        return view('staff.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:15',
            'email' => 'required|email|unique:staff,email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);
    
        // Simpan ke tabel users terlebih dahulu
        $user = User::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'staff', // Set role sebagai staff
        ]);
    
        // Simpan ke tabel staff setelah user dibuat
        Staff::create([
            'user_id' => $user->id, // Gunakan user_id yang baru saja dibuat
            'nama' => $validated['nama'],
            'alamat' => $validated['alamat'],
            'no_telepon' => $validated['no_telepon'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), // Simpan password di tabel staff
        ]);
    
        // Redirect ke halaman staff dengan pesan sukses
        return redirect()->route('staff.index')->with('success', 'Staff berhasil ditambahkan!');
    }

    public function edit($id_staff)
    {
        $staff = Staff::findOrFail($id_staff);
        return view('staff.edit', compact('staff'));
    }

    public function update(Request $request, $id_staff)
    {
        $staff = Staff::findOrFail($id_staff);

        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:staff,email,' . $id_staff . ',id_staff|unique:users,email,' . $staff->user_id,
            'no_telepon' => 'required|string|max:15',
            'alamat' => 'required|string',
        ]);

        // Update data staff
        $staff->update([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'no_telepon' => $validated['no_telepon'],
            'alamat' => $validated['alamat'],
        ]);

        // Update data pada tabel users
        $staff->user->update([
            'email' => $validated['email'],
        ]);

        return redirect()->route('staff.index')->with('success', 'Data staff berhasil diperbarui.');
    }  

    public function destroy($id)
    {
        // Cari staff berdasarkan ID
        $staff = Staff::findOrFail($id);
    
        // Hapus data terkait di tabel users
        $staff->user()->delete();
    
        // Hapus data staff
        $staff->delete();
    
        return redirect()->route('staff.index')->with('success', 'Staff dan akun pengguna berhasil dihapus.');
    }
}