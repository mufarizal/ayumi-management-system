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
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'Email Atau Password salah.'
            ]);
        }

        $request->session()->regenerate();
        
        $user = Auth::user();
        if (!$user->is_active) {
            Auth::logout();
            return back()->withErrors([
                'email'=>'Akun Anda Tidak Aktif, Hubungi Admin.'
            ]);
        }

        return match ($user->role){
            'admin'=> redirect()->route('admin.dashboard'),
            'pengajar'=> redirect()->route('pengajar.dashboard'),
            'keuangan'=> redirect()->route('keuangan.dashboard'),
        };
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
