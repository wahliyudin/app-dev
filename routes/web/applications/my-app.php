<?php

use App\Http\Controllers\Applications\MyAppController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('applications/my-app', [MyAppController::class, 'index'])->name('applications.my-app.index');
    Route::get('applications/my-app/{app_id}', [MyAppController::class, 'totalTaskEachStatusByAppId'])->name('applications.my-app.total-task-each-status-by-app-id');
});
