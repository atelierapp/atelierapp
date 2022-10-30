<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class OptionalAuthSanctum
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->bearerToken()) {
            if (Auth::guard('sanctum')->user()) {
                Auth::setUser(Auth::guard('sanctum')->user());
            }
        }

        return $next($request);
    }
}
