<?php

use App\Http\Controllers\Approval\RequestController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('approvals/requests', [RequestController::class, 'index'])->name('approvals.requests.index');
    Route::post('approvals/requests/datatable', [RequestController::class, 'datatable'])->name('approvals.requests.datatable');
    Route::get('approvals/requests/{key}/show', [RequestController::class, 'show'])->name('approvals.requests.show');
    Route::post('approvals/requests/{key}/approv', [RequestController::class, 'approv'])->name('approvals.requests.approv');
    Route::post('approvals/requests/{key}/reject', [RequestController::class, 'reject'])->name('approvals.requests.reject');
});
