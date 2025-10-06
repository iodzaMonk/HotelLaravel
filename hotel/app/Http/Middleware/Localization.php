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

    $candidate = $request->route('locale')
      ?? $request->query('lang')
      ?? $request->cookie('locale')
      ?? config('app.locale');

    $locale = in_array($candidate, $availableLocales, true)
      ? $candidate
      : config('app.fallback_locale');

    // Apply for this request
    App::setLocale($locale);
    $response = $next($request);
    return $response;
  }
}