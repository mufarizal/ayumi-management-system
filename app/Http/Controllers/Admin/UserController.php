<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(10);
        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        $roles = ['admin', 'pengajar', 'staff', 'siswa'];
        return view('admin.user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users',
            'role'  => 'required|in:admin,pengajar,staff,siswa',
        ]);

        $user = User::create([
            'name'                 => $request->name,
            'email'                => $request->email,
            'password'             => 'password123',
            'role'                 => $request->role,
            'is_active'            => true,
            'must_change_password' => true,
            'created_by'           => Auth::id(),
        ]);

        Log::info("User Created", [
            'user_id' => $user->id,
            'createdBy' => Auth::id()
        ]);

        return redirect()->route('admin.user.management.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(User $user)
    {
        $roles = ['admin', 'pengajar', 'staff', 'siswa'];
        return view('admin.user.edit', compact('roles', 'user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,pengajar,staff,siswa',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'is_active' => $request->has('is_active'),
        ]);

        Log::info("User Updated", [
            'user_id' => $user->id,
            'createdBy' => Auth::id()
        ]);

        return redirect()->route('admin.user.management')->with('success', 'User Berhasil Diupdate');
    }
    public function destroy(User $user)
    {
        $user->update(['is_active' => false]);
        Log::warning("User deactived", [
            'user_id' => $user->id,
            'createdBy' => Auth::id()
        ]);
        return back()->with('success', 'User Dinonaktifkan');
    }

    public function resetPasswordAdmin(User $user)
    {
        $user->update([
            'password' => 'password123',
            'must_change_password' => true,
        ]);

        Log::warning("Password reset By Admin", [
            'user_id' => $user->id,
            'createdBy' => Auth::id()
        ]);

        return back()->with('success', 'Password user berhasil berhasil di reset ke default.');

    }
}