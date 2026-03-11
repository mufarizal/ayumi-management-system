<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cek email dulu
        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Email tidak terdaftar.'
            ])->withInput();
        }

        if (!$user->is_active) {
            return back()->withErrors([
                'email' => 'Akun tidak aktif.'
            ])->withInput();
        }

        if (
            !Auth::attempt([
                'email' => $request->email,
                'password' => $request->password,
                'is_active' => true,
            ])
        ) {
            return back()->withErrors([
                'email' => 'Password salah.'
            ])->withInput();
        }

        $request->session()->regenerate();
        $user = Auth::user();

        if ($user->must_change_password) {
            return redirect()->route('view.reset');
        }

        $activeRole = $user->default_role ?? $user->roles->first()?->name;
        session(['active_role' => $activeRole]);

        return $this->redirectByRole($activeRole);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function showResetPassword()
    {
        return view('auth.reset-password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed'
        ]);

        $user = Auth::user();

        $user->update([
            'password' => $request->password,
            'must_change_password' => false,
        ]);

        $activeRole = $user->default_role ?? $user->roles->first()?->name;
        session(['active_role' => $activeRole]);

        return $this->redirectByRole($activeRole);
    }


    public function redirectByRole($role)
    {
        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'pengajar' => redirect()->route('pengajar.dashboard'),
            'staff' => redirect()->route('staff.dashboard'),
            'siswa' => redirect()->route('siswa.dashboard'),
            default => abort(403),
        };
    }

    public function switchRole(Request $request)
    {
        $request->validate([
            'role' => 'required|string'
        ]);

        $user = Auth::user();
        $role = $request->role;

        $user = $request->user();
        if (!$user || !$user->hasRole($role)) {
            abort(403, 'Anda tidak memiliki peran pada role tersebut.');
        }

        session(['active_role' => $role]);
        return $this->redirectByRole($role);
    }
}