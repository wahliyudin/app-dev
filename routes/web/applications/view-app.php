<?php

use App\Http\Controllers\Applications\ViewAppController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('applications/{id}/view-app', [ViewAppController::class, 'index'])->name('applications.view-app.index');
    Route::post('applications/view-app/task-overtime', [ViewAppController::class, 'taskOvertime'])->name('applications.view-app.task-overtime');
});
