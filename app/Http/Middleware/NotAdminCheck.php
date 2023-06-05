<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NotAdminCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->guest()) {
            return redirect()->route('auth.login');
        } elseif (auth()->check() && auth()->user()->role <> "Admin") {
            return $next($request);
        } else {
            abort(403, 'Uauthorized action.');
        }
    }
}
