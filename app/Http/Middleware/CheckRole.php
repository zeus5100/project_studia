<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next;
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (! $request->user()->hasRole($role)) {
            abort(403, 'This action is unauthorized.');
        }

        return $next($request);
    }
}
