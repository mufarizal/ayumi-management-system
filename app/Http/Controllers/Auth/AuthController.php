<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        if (
            !Auth::attempt([
                'email' => $request->email,
                'password' => $request->password,
                'is_active' => true
            ])
        ) {
            return back()->withErrors([
                'email' => 'Email / Password salah atau akun tidak aktif.'
            ]);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->must_change_password) {
            return redirect()->route('view.reset');
        }

        return $this->redirectByRole($user);
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

        return $this->redirectByRole($user);
    }

    private function redirectByRole($user)
    {
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->hasRole('pengajar')) {
            return redirect()->route('pengajar.dashboard');
        }

        if ($user->hasRole('staff')) {
            return redirect()->route('staff.dashboard');
        }

        if ($user->hasRole('siswa')) {
            return redirect()->route('siswa.dashboard');
        }

        abort(403);
    }
}