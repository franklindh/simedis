<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotPetugas
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    public function handle($request, Closure $next, ...$roles)
    {
        if (Auth::guard('petugas')->check()) {
            $userRole = Auth::guard('petugas')->user()->role;

            // Jika '*' diberikan, izinkan semua role
            if (in_array('*', $roles) || in_array($userRole, $roles)) {
                return $next($request);
            } else {
                return redirect()->route('logout')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
                // return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }
        }

        // Redirect jika user belum login
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }

}
