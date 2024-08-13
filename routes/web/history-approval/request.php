<?php

use App\Http\Controllers\HistoryApproval\RequestController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('history-approvals/requests', [RequestController::class, 'index'])->name('history-approvals.requests.index');
    Route::post('history-approvals/requests/datatable', [RequestController::class, 'datatable'])->name('history-approvals.requests.datatable');
    Route::get('history-approvals/requests/{key}/show', [RequestController::class, 'show'])->name('history-approvals.requests.show');
});
