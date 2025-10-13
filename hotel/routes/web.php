<?php

use App\Http\Controllers\HotelController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HotelController::class, 'hub'])->name('home');
Route::get('/catalog', [HotelController::class, 'catalog'])->name('hotels.catalog');
Route::get('/hotels/suggest', [HotelController::class, 'suggest'])->name('hotels.suggest');

Route::prefix('admin')
    ->middleware(['auth', 'verified', 'admin'])
    ->name('admin.')
    ->group(function () {
        Route::get('/', function () {
            $cards = [
                [
                    'title' => __('admin.dashboard.cards.hotels.title'),
                    'description' => __('admin.dashboard.cards.hotels.description'),
                    'href' => route('admin.hotels.index'),
                    'image' => __('admin.dashboard.cards.hotels.image'),
                ],
                [
                    'title' => __('admin.dashboard.cards.rooms.title'),
                    'description' => __('admin.dashboard.cards.rooms.description'),
                    'href' => route('admin.rooms.index'),
                    'image' => __('admin.dashboard.cards.rooms.image'),
                ],
            ];

            return Inertia::render('Admin/Dashboard', [
                'copy' => [
                    'headTitle' => __('admin.dashboard.head_title'),
                    'heading' => __('admin.dashboard.heading'),
                    'description' => __('admin.dashboard.description'),
                    'enterLabel' => __('admin.common.enter_dashboard'),
                ],
                'cards' => $cards,
            ]);
        })->name('dashboard');
        Route::resource('hotels', HotelController::class);
        Route::resource('rooms', RoomController::class);
    });

Route::resource('users', UserController::class);

Route::get('locale/{locale}', [LocalizationController::class, 'index'])->name(
    'locale.switch',
);

require __DIR__ . '/auth.php';
