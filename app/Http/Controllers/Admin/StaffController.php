<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staff = Staff::with('user')->paginate(10);

        return view('admin.user.staff.index', compact('staff'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::whereHas('roles', function ($q) {
            $q->where('name', 'staff');
        })
            ->whereDoesntHave('staff') // INI YANG PENTING
            ->where('is_active', true)
            ->get();

        return view('admin.user.staff.create', compact('users'));
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
                'unique:staff,user_id'
            ],
            'jabatan' => 'required|string|max:100',
            'departemen' => 'required|string|max:100',
            'tgl_bergabung' => 'required|date',
            'is_active' => 'required|boolean'
        ]);

        Staff::create([
            'user_id' => $request->user_id,
            'jabatan' => $request->jabatan,
            'departemen' => $request->departemen,
            'tanggal_bergabung' => $request->tgl_bergabung,
            'is_active' => $request->is_active
        ]);

        return redirect()->route('admin.staff.index')->with('success', 'Staff berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $id = Crypt::decrypt($id);
        $staff = Staff::with('user')->findOrFail($id);
        return view('admin.user.staff.show', compact('staff'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $id = Crypt::decrypt($id);
        $staff = Staff::with('user')->findOrFail($id);
        return view('admin.user.staff.edit', compact('staff'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $staff = Staff::findOrFail($id);
        $request->validate([
            'jabatan' => 'required|string|max:100',
            'departemen' => 'required|string|max:100',
            'tgl_bergabung' => 'required|date',
            'is_active' => 'required|boolean'
        ]);

        $staff->update([
            'jabatan' => $request->jabatan,
            'departemen' => $request->departemen,
            'tanggal_bergabung' => $request->tgl_bergabung,
            'is_active' => $request->is_active
        ]);

        return redirect()->route('admin.staff.index')->with('success', 'Staff berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
