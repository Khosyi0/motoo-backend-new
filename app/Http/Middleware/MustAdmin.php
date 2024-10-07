<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MustAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Check if the user's role is 'admin'
            if ($user->role == 'admin') {
                return $next($request);
            }
        }
        // If not authenticated or not an admin, redirect to the home page or show an error
        return response()->json([
            'error' => 'You do not have admin access.'
        ], 403);
    }
}
