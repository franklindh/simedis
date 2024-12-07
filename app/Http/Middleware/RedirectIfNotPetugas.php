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
        $user = Auth::guard('petugas')->user();

        // Cek apakah pengguna sudah login
        if ($user) {
            $userRole = $user->role;

            // Cek apakah role pengguna sesuai dengan salah satu role yang diizinkan atau '*' untuk semua role
            if (in_array('*', $roles) || in_array($userRole, $roles)) {
                // Cek apakah status pengguna aktif
                if ($user->status === 'aktif') {
                    return $next($request);
                }
                \Log::info('User nonaktif mencoba akses.', ['user' => $user]);
                // Jika status pengguna tidak aktif
                return redirect()->route('login')->with('error', 'Akun Anda tidak aktif. Silakan hubungi admin.');
            }
            \Log::info('Role tidak sesuai.', ['user' => $user, 'roles' => $roles]);
            // Jika role pengguna tidak sesuai
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses.');

        }
        \Log::info('Pengguna belum login.');
        // Redirect jika pengguna belum login
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }


}
