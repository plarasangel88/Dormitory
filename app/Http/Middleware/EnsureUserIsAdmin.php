<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // User is not logged in
        if (!Auth()->check()) {
            return redirect('/login');
        }

        // User is logged in but isn't an admin
        if (Auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized - Admin access only.');
        }

        return $next($request);
    }
}