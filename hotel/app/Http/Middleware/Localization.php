<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;

class Localization
{
    public function handle(Request $request, Closure $next)
    {
        $availableLocales = config('app.available_locales', []);
        $locale = session('locale') ?? $request->cookie('locale') ?? config('app.locale');

        if (! in_array($locale, $availableLocales, true)) {
            $locale = config('app.fallback_locale');
        }

        if (session('locale') !== $locale) {
            session()->put('locale', $locale);
        }

        if ($request->cookie('locale') !== $locale) {
            Cookie::queue('locale', $locale, 60 * 24 * 365);
        }

        App::setLocale($locale);

        return $next($request);
    }
}
