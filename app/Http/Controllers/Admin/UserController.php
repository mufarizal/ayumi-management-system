<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index(Request $request, $role = null)
    {

        $query = User::with('roles');

        if ($role) {
            $query->whereHas('roles', function ($q) use ($role) {
                $q->where('name', $role);
            });
        }

        $users = $query->latest()->paginate(10);

        return view('admin.user.index', compact('users', 'role'));
    }
    public function search(Request $request)
    {
        $keyword = $request->get('q', '');
        $role = $request->get('role', null);

        $query = User::with('roles');

        if ($role) {
            $query->whereHas('roles', function ($q) use ($role) {
                $q->where('name', $role);
            });
        }

        // Filter pencarian nama / email
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%');
            });
        }

        $users = $query->latest()->get();

        return response()->json([
            'users' => $users->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => ucfirst($user->roles->first()->name ?? '-'),
                    'is_active' => $user->is_active,
                    'edit_url' => route('admin.users.edit', $user),
                    'reset_url' => route('admin.users.reset', $user),
                    'delete_url' => route('admin.users.delete', $user),
                ];
            }),
        ]);
    }


    public function create($role)
    {
        return view('admin.user.create', compact('role'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'role' => 'required|in:admin,pengajar,staff,siswa',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('password123'),
            'is_active' => true,
            'must_change_password' => true,
            'created_by' => Auth::id(),
        ]);

        $role = Role::where('name', $request->role)->first();
        $user->roles()->attach($role->id);

        Log::info("User Created", [
            'user_id' => $user->id,
            'createdBy' => Auth::id(),
        ]);

        return redirect()->route('admin.users.' . $request->role)
            ->with('success', 'User berhasil dibuat');
    }


    public function edit(User $user)
    {
        $role = $user->roles->first()->name ?? null;

        return view('admin.user.edit', compact('user', 'role'));
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
            'is_active' => $request->has('is_active'),
        ]);

        $role = Role::where('name', $request->role)->first();
        $user->roles()->sync([$role->id]);

        Log::info("User Updated", [
            'user_id' => $user->id,
            'createdBy' => Auth::id(),
        ]);

        return redirect()->route('admin.users.' . $request->role)
            ->with('success', 'User berhasil diupdate');
    }


    public function destroy(User $user)
    {
        $user->update(['is_active' => false]);

        Log::warning("User Deactivated", [
            'user_id' => $user->id,
            'createdBy' => Auth::id(),
        ]);

        return back()->with('success', 'User dinonaktifkan');
    }


    public function resetPasswordAdmin(User $user)
    {
        $user->update([
            'password' => Hash::make('password123'),
            'must_change_password' => true,
        ]);

        Log::warning("Password reset by Admin", [
            'user_id' => $user->id,
            'createdBy' => Auth::id(),
        ]);

        return back()->with('success', 'Password berhasil di reset');
    }
}