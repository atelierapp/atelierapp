<?php

namespace App\Http\Middleware;

use App\Exceptions\AtelierException;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

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
            [$locale, $country] = $this->getLocaleAndCountry($request->header('x-locale'));

            config(['app.country' => $country]);
            App::setLocale($locale);
        }

        return $next($request);
    }

    /**
     * @throws \App\Exceptions\AtelierException
     */
    private function getLocaleAndCountry(array|string|null $header): array
    {
        if (!in_array(strtolower($header), ['en-us', 'es-pe'])) {
            throw new AtelierException('Invalid "X-Locale" header', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return explode('-', $header);
    }
}
