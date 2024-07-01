<?php

use App\Http\Controllers\Applications\FeatureController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('applications/{id}/features', [FeatureController::class, 'index'])->name('applications.features.index');
    Route::post('applications/{id}/features/datatable', [FeatureController::class, 'datatable'])->name('applications.features.datatable');
    Route::post('applications/features/store', [FeatureController::class, 'store'])->name('applications.features.store');
    Route::get('applications/features/{key}/edit', [FeatureController::class, 'edit'])->name('applications.features.edit');
    Route::delete('applications/features/{key}/destroy', [FeatureController::class, 'destroy'])->name('applications.features.destroy');
});
