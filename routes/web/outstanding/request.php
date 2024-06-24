<?php

use App\Http\Controllers\Outstanding\RequestController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('outstandings/requests', [RequestController::class, 'index'])->name('outstandings.requests.index');
    Route::post('outstandings/requests/datatable', [RequestController::class, 'datatable'])->name('outstandings.requests.datatable');
    Route::get('outstandings/requests/developers', [RequestController::class, 'developers'])->name('outstandings.requests.developers');
    Route::get('outstandings/requests/{key}/setting', [RequestController::class, 'setting'])->name('outstandings.requests.setting');
    Route::post('outstandings/requests/store', [RequestController::class, 'store'])->name('outstandings.requests.store');
});
