<?php

use App\Http\Controllers\RequestController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('requests', [RequestController::class, 'index'])->name('requests.index');
    Route::post('requests/datatable', [RequestController::class, 'datatable'])->name('requests.datatable');
    Route::get('requests/create', [RequestController::class, 'create'])->name('requests.create');
    Route::post('requests/store', [RequestController::class, 'store'])->name('requests.store');
    Route::get('requests/{key}/edit', [RequestController::class, 'edit'])->name('requests.edit');
    Route::post('requests/upload', [RequestController::class, 'upload'])->name('requests.upload');
    Route::post('requests/remove', [RequestController::class, 'remove'])->name('requests.remove');
    Route::get('requests/{key}/files', [RequestController::class, 'files'])->name('requests.files');
    Route::post('requests/employees', [RequestController::class, 'employees'])->name('requests.employees');
});
