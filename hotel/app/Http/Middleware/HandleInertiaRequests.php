<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user()
                    ? $request->user()->only(['id', 'name', 'email', 'is_admin'])
                    : null,
            ],
            'appMeta' => [
                'brand' => __('hotel.brand'),
                'footer' => [
                    'all_rights_reserved' => __('hotel.footer.all_rights_reserved'),
                ],
                'locale' => [
                    'current' => app()->getLocale(),
                    'available' => config('app.available_locales', []),
                    'links' => collect(config('app.available_locales', []))
                        ->mapWithKeys(fn(string $code) => [
                            $code => route('locale.switch', ['locale' => $code]),
                        ])
                        ->all(),
                ],
                'nav' => [
                    'explore' => __('hotel.nav.explore'),
                    'admin' => __('hotel.nav.admin'),
                    'offers' => __('hotel.nav.offers'),
                    'support' => __('hotel.nav.support'),
                    'contact' => __('hotel.nav.contact'),
                    'login' => __('hotel.nav.login'),
                    'register' => __('hotel.nav.register'),
                    'logout' => __('hotel.nav.logout'),
                ],
            ],
        ];
    }
}
