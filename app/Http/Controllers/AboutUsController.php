<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutUsController extends Controller
{
    public function __invoke(Request $request)
    {
        $brands = app()->getLocale() === 'en'
            ? $this->getBrands('en', amount: 12)
            : $this->getBrands('es', amount: 19);

        return view('about')->with('brands', $brands);
    }

    private function getBrands(string $locale, int $amount): array
    {
        $images = [];

        for ($i = 1; $i <= $amount; $i++) {
            $images[] = asset(sprintf('images/brands/%s/brand_%d.png', $locale, $i));
        }

        return $images;
    }
}
