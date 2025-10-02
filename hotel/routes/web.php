<?php

use App\Http\Controllers\HotelController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('hub'))->name('home');

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', fn () => view('admin.admin-controls'))->name('dashboard');
        Route::resource('hotels', HotelController::class);
        Route::resource('rooms', RoomController::class)->only(['index']);
    });

Route::resource('users', UserController::class);
Route::get('/login', fn () => view('auth.login'))->name('login');
Route::get('locale/{locale}', [LocalizationController::class, 'index'])->name('locale.switch');

