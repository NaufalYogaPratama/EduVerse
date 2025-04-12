<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MaterialController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [MaterialController::class, 'index'])
    ->middleware(['auth']) // Hapus 'verified' untuk testing
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('materials', MaterialController::class)->except(['index']);
    Route::post('materials/{material}/approve', [MaterialController::class, 'approve'])->name('materials.approve');
    Route::delete('materials/force/{id}', [MaterialController::class, 'forceDelete'])->name('materials.forceDelete');
    Route::get('/trash', [MaterialController::class, 'trash'])->name('materials.trash');
    Route::post('/trash/{material}/restore', [MaterialController::class, 'restore'])->name('materials.restore');
});

Route::get('/stats', [MaterialController::class, 'stats'])->name('materials.stats');

require __DIR__.'/auth.php';