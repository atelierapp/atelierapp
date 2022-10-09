<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageSwitcherController extends Controller
{
    public function __invoke(Request $request, string $locale): RedirectResponse
    {
        App::setLocale($locale);
        Session::put('locale', $locale);

        return redirect()->back();
    }
}
