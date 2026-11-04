<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminIsAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        // Check if an admin is logged in
        if (!$request->session()->has('admin_id')) {

            return redirect('/login?tab=registrar')
                ->with('error', 'Please log in as registrar first.');
        }

        return $next($request);
    }
}