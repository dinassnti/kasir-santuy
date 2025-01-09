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
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:15',
            'email' => 'required|email|unique:staff,email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);
    
        $user = User::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'staff', 
        ]);
    
        Staff::create([
            'user_id' => $user->id, 
            'nama' => $validated['nama'],
            'alamat' => $validated['alamat'],
            'no_telepon' => $validated['no_telepon'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), 
        ]);
    
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

        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:staff,email,' . $id_staff . ',id_staff|unique:users,email,' . $staff->user_id,
            'no_telepon' => 'required|string|max:15',
            'alamat' => 'required|string',
        ]);

        $staff->update([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'no_telepon' => $validated['no_telepon'],
            'alamat' => $validated['alamat'],
        ]);

        $staff->user->update([
            'email' => $validated['email'],
        ]);

        return redirect()->route('staff.index')->with('success', 'Data staff berhasil diperbarui.');
    }  

    public function destroy($id)
    {
        $staff = Staff::findOrFail($id);
        $staff->user()->delete();
        $staff->delete();
    
        return redirect()->route('staff.index')->with('success', 'Staff dan akun pengguna berhasil dihapus.');
    }
}