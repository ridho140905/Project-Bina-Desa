<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
         if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = Auth::user()->role;

        // Super Admin boleh akses SEMUA
        if ($userRole === 'Super Admin') {
            return $next($request);
        }

        // Admin hanya boleh jika route mengizinkan Admin
        if ($userRole === 'Admin' && $role === 'Admin') {
            return $next($request);
        }

        abort(403, 'Anda tidak memiliki akses ke halaman ini');

  }
}
