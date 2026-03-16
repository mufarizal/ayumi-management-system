<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Pendaftaran;
use App\Models\Program;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pendaftarans = Pendaftaran::with(['program', 'kelas'])->latest()->get();
        return view('admin.academic_managements.pendaftaran.index', compact('pendaftarans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $programs = Program::all();
        $kelas = Kelas::all();
        return view('admin.academic_managements.pendaftaran.create', compact('programs', 'kelas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pendaftarans,email',
            'no_telp' => 'required|string|max:20',
            'institusi' => 'required|string|max:255',
            'program_id' => 'required|exists:programs,id',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        Pendaftaran::create($request->all());

        return redirect()->route('admin.pendaftaran.index')->with('success', 'Pendaftaran berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $programs = Program::all();
        $kelas = Kelas::all();
        return view('admin.academic_managements.pendaftaran.edit', compact('pendaftaran', 'programs', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        $pendaftaran->update($request->all());

        return redirect()->route('admin.pendaftaran.index')
            ->with('success', 'Pendaftaran berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->delete();

        return back()->with('success', 'Pendaftaran berhasil dihapus');
    }
}
