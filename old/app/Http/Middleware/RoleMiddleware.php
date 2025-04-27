<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = Auth::user();
        $selectedRole = session('selected_role');

        if (!$user || !$selectedRole) {

            Alert::error('Warning', 'Unauthorized access.');
            return redirect('/');
        }

        if (!in_array($selectedRole, $roles)) {

            Alert::error('Warning', 'Unauthorized access.');
            return redirect('/dashboard');
        }

        return $next($request);
    }
}
