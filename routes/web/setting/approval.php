<?php

use App\Http\Controllers\Setting\ApprovalController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('settings/approval', [ApprovalController::class, 'index'])->name('settings.approval.index')->middleware('permission:setting_approval_read');
    Route::post('settings/approval/store', [ApprovalController::class, 'store'])->name('settings.approval.store')->middleware('permission:setting_approval_update');
});
