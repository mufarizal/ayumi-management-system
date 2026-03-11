<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if (!$user->hasRole($role)) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $activeRole = session('active_role')
            ?? $user->default_role
            ?? $user->roles->first()?->name;

        if ($activeRole !== $role) {
            return match ($activeRole) {
                'admin' => redirect()->route('admin.dashboard'),
                'pengajar' => redirect()->route('pengajar.dashboard'),
                'staff' => redirect()->route('staff.dashboard'),
                'siswa' => redirect()->route('siswa.dashboard'),
                default => abort(403),
            };
        }

        return $next($request);
    }
}