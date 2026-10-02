<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return redirect()->route('activities.index');
});

// Route Transisi Status Activity (Task 2)
Route::patch('activities/{activity}/publish', [ActivityController::class, 'publish'])->name('activities.publish');
Route::patch('activities/{activity}/complete', [ActivityController::class, 'complete'])->name('activities.complete');

// Route Hapus Kategori (AC-03)
Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

// Resource Route Activity
Route::resource('activities', ActivityController::class);