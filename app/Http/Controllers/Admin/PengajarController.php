<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengajar;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class PengajarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengajar = Pengajar::with('user')->paginate(10);

        return view('admin.user.pengajar.index', compact('pengajar'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::whereHas('roles', function ($q) {
            $q->where('name', 'pengajar');
        })
            ->whereDoesntHave('pengajar') // INI YANG PENTING
            ->where('is_active', true)
            ->get();

        return view('admin.user.pengajar.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => [
                'required',
                'exists:users,id',
                'unique:pengajar,user_id'
            ],
            'no_telp' => 'required|string|max:20',
            'nama_bank' => 'required|string|max:100',
            'no_rekening' => 'required|string|max:50',
            'level_bahasa' => 'required|in:N1,N2,N3,N4,N5',
            'alamat' => 'required|string',
            'sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'is_active' => 'required|boolean'
        ]);

        $certificatePath = null;

        if ($request->hasFile('sertifikat')) {
            $certificatePath = $request->file('sertifikat')->store('certificates', 'public');
        }

        Pengajar::create([
            'user_id' => $request->user_id,
            'no_telp' => $request->no_telp,
            'no_rekening' => $request->no_rekening,
            'nama_bank' => $request->nama_bank,
            'level_bahasa' => $request->level_bahasa,
            'alamat' => $request->alamat,
            'sertifikat' => $certificatePath,
            'is_active' => true,
        ]);

        return redirect()
            ->route('admin.pengajar.index')
            ->with('success', 'Pengajar berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $id = Crypt::decrypt($id);
        $pengajar = Pengajar::with('user')->findOrFail($id);
        return view('admin.user.pengajar.show', compact('pengajar'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $id = Crypt::decrypt($id);
        $pengajar = Pengajar::with('user')->findOrFail($id);
        return view('admin.user.pengajar.edit', compact('pengajar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $pengajar = Pengajar::findOrFail($id);
        $request->validate([
            'no_telp' => 'required|string|max:20',
            'nama_bank' => 'required|string|max:100',
            'no_rekening' => 'required|string|max:50',
            'alamat' => 'required|string',
            'level_bahasa' => 'required|in:N1,N2,N3,N4,N5',
            'sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'is_active' => 'required|boolean'
        ]);

        $certificatePath = $pengajar->sertifikat;

        if ($request->hasFile('sertifikat')) {
            $certificatePath = $request->file('sertifikat')->store('certificates', 'public');
        }

        $pengajar->update([
            'no_telp' => $request->no_telp,
            'no_rekening' => $request->no_rekening,
            'nama_bank' => $request->nama_bank,
            'alamat' => $request->alamat,
            'level_bahasa' => $request->level_bahasa,
            'sertifikat' => $certificatePath,
            'is_active' => $request->is_active,
        ]);

        return redirect()
            ->route('admin.pengajar.index')
            ->with('success', 'Pengajar berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pengajar = Pengajar::findOrFail($id);

        $pengajar->update([
            'is_active' => false
        ]);

        return back()->with('success', 'Pengajar berhasil dinonaktifkan');
    }
}
