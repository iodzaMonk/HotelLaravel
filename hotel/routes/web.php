<?php

use App\Http\Controllers\HotelController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('hub');
});

Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.index');


Route::resources([
    'hotels' => HotelController::class,
    'rooms' => RoomController::class,
]);