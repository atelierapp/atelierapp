<?php

namespace App\Http\Middleware;

use App\Exceptions\AtelierException;
use Closure;
use Illuminate\Http\Request;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\AtelierException
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->hasHeader('x-locale')) {
            // TODO :  this shit 🤣 work for first intent, but this will be optimize to in a provider
            [$locale, $country] = $this->getLocaleAndCountry($request->header('x-locale'));

            config(['app.country' => $country]);
            config(['app.locale' => $locale]);
        }

        return $next($request);
    }

    /**
     * @throws \App\Exceptions\AtelierException
     */
    private function getLocaleAndCountry(array|string|null $header)
    {
        if (is_null($header)) {
            throw new AtelierException('Missing "x-locale" header', 422);
        }

        if (!in_array(strtolower($header), ['en-us', 'es-pe'])) {
            throw new AtelierException('Invalid "x-locale" header', 422);
        }

        return explode('-', $header);
    }
}
