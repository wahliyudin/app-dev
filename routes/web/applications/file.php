<?php

use App\Http\Controllers\Applications\FileController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('applications/{id}/files', [FileController::class, 'index'])->name('applications.files.index');
});
