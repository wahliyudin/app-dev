<?php

use App\Http\Controllers\OAuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->guard()) {
        return to_route('login');
    }
    return to_route('home');
});

Auth::routes(['register' => false]);
Route::get('sso/login', [OAuthController::class, 'login'])->name('sso.login');
Route::get('sso/callback', [OAuthController::class, 'callback'])->name('sso.callback');
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('globals/sidebar', [App\Http\Controllers\GlobalController::class, 'sidebar'])->name('globals.sidebar');
});
