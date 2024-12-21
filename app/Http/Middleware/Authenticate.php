<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Closure;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }


    public function handle($request, Closure $next, ...$guards)
    {
        if (auth()->guard('api')->check() ) {
            return $next($request);
        }

        return sendError('Unauthenticated.', [], 401);
    }
}
