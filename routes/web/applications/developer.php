<?php

use App\Http\Controllers\Applications\DeveloperController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('applications/{id}/developers', [DeveloperController::class, 'index'])->name('applications.developers.index');
    Route::post('applications/{id}/developers/datatable', [DeveloperController::class, 'datatable'])->name('applications.developers.datatable');
    Route::post('applications/developers/store', [DeveloperController::class, 'store'])->name('applications.developers.store');
    Route::get('applications/developers/{key}/edit', [DeveloperController::class, 'edit'])->name('applications.developers.edit');
    Route::delete('applications/developers/{key}/destroy', [DeveloperController::class, 'destroy'])->name('applications.developers.destroy');
    Route::post('applications/developers', [DeveloperController::class, 'developers'])->name('applications.developers');
});
