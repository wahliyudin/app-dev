<?php

use App\Http\Controllers\Applications\ActivityController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('applications/{id}/activities', [ActivityController::class, 'index'])->name('applications.activities.index');
});
