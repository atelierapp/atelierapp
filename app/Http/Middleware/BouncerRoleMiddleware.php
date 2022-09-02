<?php

namespace App\Http\Middleware;

use App\Exceptions\AtelierException;
use Bouncer;
use Closure;
use Illuminate\Http\Request;

class BouncerRoleMiddleware
{
    /**
     * @throws \App\Exceptions\AtelierException
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (Bouncer::is($request->user())->notA($role)) {
            throw new AtelierException(__('authorization.without_access'), 401);
        }

        return $next($request);
    }
}
