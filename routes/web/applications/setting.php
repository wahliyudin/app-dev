<?php

use App\Http\Controllers\Applications\SettingController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('applications/{id}/settings', [SettingController::class, 'index'])->name('applications.settings.index');
});
