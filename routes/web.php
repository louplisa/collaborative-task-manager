<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('base');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/projects', [\App\Http\Controllers\ProjectController::class, 'index'])->name('project.index');
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {
//    Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

//    Project routes
    Route::get('/projects/{project}', [\App\Http\Controllers\Admin\ProjectController::class, 'show'])->name('project.show');
    Route::get('/projects', [\App\Http\Controllers\Admin\ProjectController::class, 'index'])->name('project.index');
    Route::get('/projects/create', [\App\Http\Controllers\Admin\ProjectController::class, 'create'])->name('project.create');
    Route::post('/projects', [\App\Http\Controllers\Admin\ProjectController::class, 'store'])->name('project.store');
    Route::get('/projects/{project}/edit', [\App\Http\Controllers\Admin\ProjectController::class, 'edit'])->name('project.edit');
    Route::put('/projects/{project}', [\App\Http\Controllers\Admin\ProjectController::class, 'update'])->name('project.update');
    Route::delete('/projects/{project}', [\App\Http\Controllers\Admin\ProjectController::class, 'destroy'])->name('project.destroy');
});

require __DIR__.'/auth.php';
