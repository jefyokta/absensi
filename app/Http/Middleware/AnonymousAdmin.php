<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AnonymousAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->is_superadmin) {
            return $next($request);
        } else {

            if (auth()->user()->is_admin && !auth()->user()->division_id) {
                return $next($request);
            } else {
                return abort(403);
            }
        }
    }
}
