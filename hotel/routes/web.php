<?php

use App\Http\Controllers\HotelController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

// Route::resources([
//     'hotels' => HotelController::class,
//     'rooms' => RoomController::class,
// ]);


Route::get('/', function () {
    return view('hub');
});