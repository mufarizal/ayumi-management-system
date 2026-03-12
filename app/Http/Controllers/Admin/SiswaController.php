<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siswa = Siswa::with('user')->paginate(10);

        return view('admin.user.siswa.index', compact('siswa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::whereHas('roles', function ($q) {
            $q->where('name', 'siswa');
        })
            ->whereDoesntHave('siswa') // INI YANG PENTING
            ->where('is_active', true)
            ->get();

        return view('admin.user.siswa.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // VALIDASI
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:siswa,user_id',
            'no_telp' => 'required|string|max:20',
            'nama_institusi' => 'required|string|max:100',
            'is_active' => 'required|boolean'
        ]);

        // AMBIL USER YANG SUDAH ADA
        $user = User::findOrFail($request->user_id);

        // UPDATE STATUS USER
        $user->update([
            'is_active' => $request->is_active
        ]);

        // TAMBAHKAN ROLE SISWA
        $role = Role::where('name', 'siswa')->first();
        $user->roles()->syncWithoutDetaching([$role->id]);

        // BUAT DATA SISWA
        Siswa::create([
            'user_id' => $user->id,
            'no_telp' => $request->no_telp,
            'nama_institusi' => $request->nama_institusi
        ]);

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Siswa berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $id = Crypt::decrypt($id);
        $siswa = Siswa::with('user')->findOrFail($id);
        return view('admin.user.siswa.show', compact('siswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $id = Crypt::decrypt($id);
        $siswa = Siswa::with('user')->findOrFail($id);
        return view('admin.user.siswa.edit', compact('siswa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $siswa = Siswa::findOrFail($id);
        $request->validate([
            'no_telp' => 'required|string|max:100',
            'nama_institusi' => 'required|string|max:100',
            'is_active' => 'required|boolean'
        ]);

        $siswa->update([
            'no_telp' => $request->no_telp,
            'nama_institusi' => $request->nama_institusi,
            'is_active' => $request->is_active
        ]);

        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
