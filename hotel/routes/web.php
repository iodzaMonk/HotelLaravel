<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// home route
Route::get("/", fn() => view("hub"))->name("home");

// public catalog
Route::get('/catalog', [HotelController::class, 'catalog'])->name('hotels.catalog');
Route::get('/hotels/suggest', [HotelController::class, 'suggest'])->name('hotels.suggest');

// admin routes
Route::prefix("admin")->middleware(['auth', 'verified', 'admin'])
    ->name("admin.")
    ->group(function () {
        Route::get("/", fn() => view("admin.admin-controls"))->name(
            "dashboard",
        );
        Route::resource("hotels", HotelController::class);
        Route::resource("rooms", RoomController::class);
    });

Route::resource("users", UserController::class);
Route::get("locale/{locale}", [LocalizationController::class, "index"])->name(
    "locale.switch",
);


// guest routes
Route::middleware('guest')->controller(AuthController::class)->group(function () {
    Route::get('/register', "showRegister")->name('show.register');
    Route::get('/login', "showLogin")->name('show.login');
    Route::post('/register', "register")->name('register');
    Route::post('/login', "login")->name('login');
});
Route::post('/logout', [AuthController::class, "logout"])->name('logout');




// email verification
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect()->route('home');
})->middleware(['auth', 'signed', 'throttle:6,1'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    if ($request->user()->hasVerifiedEmail()) {
        return redirect()->intended(route('home'));
    }

    $request->user()->sendEmailVerificationNotification();

    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
