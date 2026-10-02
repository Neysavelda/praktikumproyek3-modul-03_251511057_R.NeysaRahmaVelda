<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return redirect()->route('activities.index');
});

// Route Soft Delete (Wajib di atas resource agar URL /trashed tidak dianggap sebagai {activity})
Route::get('activities/trashed', [ActivityController::class, 'trashed'])->name('activities.trashed');
Route::post('activities/{id}/restore', [ActivityController::class, 'restore'])->name('activities.restore');
Route::delete('activities/{id}/force-delete', [ActivityController::class, 'forceDelete'])->name('activities.force-delete');

// Route Status Transitions & Category
Route::patch('activities/{activity}/publish', [ActivityController::class, 'publish'])->name('activities.publish');
Route::patch('activities/{activity}/complete', [ActivityController::class, 'complete'])->name('activities.complete');
Route::delete('categories/{category}', [ActivityController::class, 'destroyCategory'])->name('categories.destroy');

// Route Resource Utama
Route::resource('activities', ActivityController::class);