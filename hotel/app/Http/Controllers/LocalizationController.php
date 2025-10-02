<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;

class LocalizationController extends Controller
{
    public function index(string $locale): RedirectResponse
    {
        $availableLocales = config('app.available_locales', []);

        if (!in_array($locale, $availableLocales, true)) {
            abort(404);
        }

        App::setLocale($locale);
        session()->put('locale', $locale);
        Cookie::queue('locale', $locale, 60 * 24 * 365);

        return redirect()->back();
    }
}