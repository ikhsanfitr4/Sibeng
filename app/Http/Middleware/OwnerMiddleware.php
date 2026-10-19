<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OwnerMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ❌ Kalau belum login → lempar ke login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // ❌ Kalau bukan owner → blok akses
        if (Auth::user()->role !== 'owner') {
            abort(403, 'Forbidden - Owner only');
        }

        // ✅ Lolos
        return $next($request);
    }
}