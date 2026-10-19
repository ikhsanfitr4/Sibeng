<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     * Hanya mengizinkan user dengan role 'admin'.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 🔒 Belum login → redirect
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // ❌ Bukan admin → blok
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Halaman ini khusus untuk Admin.');
        }

        // ✅ Lolos
        return $next($request);
    }
}