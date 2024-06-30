<?php

use App\Http\Controllers\Applications\SettingController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('applications/{id}/settings', [SettingController::class, 'index'])->name('applications.settings.index');
    Route::post('applications/{id}/settings/store', [SettingController::class, 'store'])->name('applications.settings.store');
});
