<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use RealRashid\SweetAlert\Facades\Alert;

class CheckAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() && !$request->is('/')) {
            Alert::error('Warning', 'You must log in first.');
            return redirect('/');
        }

        if (Auth::check() && $request->is('/')) {
            return redirect('/dashboard');
        }


        return $next($request);
    }
}
