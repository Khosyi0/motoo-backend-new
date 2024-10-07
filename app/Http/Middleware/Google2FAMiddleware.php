<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class Google2FAMiddleware
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        // \Log::info('Middleware check', ['user' => $user, '2fa_verified' => $request->json('2fa_verified')]);
    
        // Periksa apakah pengguna sudah masuk dan memiliki google2fa_secret
        if ($user) {
            if ($user->google2fa_secret == null) {
                // Jika pengguna belum memiliki google2fa_secret, arahkan ke halaman registrasi 2FA
                // return redirect()->route('2fa.registration');
                return response()->json([
                    'message' => 'User Invalid',
                    // 'key' => false,
                ], 403);

            } elseif ($user->is_2fa_enabled == false) {
                // return redirect()->route('2fa.registration');
                return response()->json([
                    'message' => '2FA is not Enabled'

                ], 403);

            }elseif (!$request->json('mfa_verified')) {
                // Jika pengguna belum diverifikasi dengan 2FA, arahkan ke halaman verifikasi 2FA
                // return redirect()->route('2fa');
                return response()->json([
                    'message' => 'Need to Verify 2FA',
                    
                ], 403);

            }
            // elseif (!$request->session()->has('2fa_verified')) {
            //     // Jika pengguna belum diverifikasi dengan 2FA, arahkan ke halaman verifikasi 2FA
            //     return redirect()->route('2fa');
            // }
        }
    
        return $next($request);
    }
}

