<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::post('/tasks', [App\Http\Controllers\TaskController::class, 'store'])->middleware(['auth', 'verified'])->name('tasks.create');
Route::patch('/tasks/{task}', [App\Http\Controllers\TaskController::class, 'update'])->middleware(['auth', 'verified'])->name('tasks.update');
Route::get('/tasks/{task}/{status}', [App\Http\Controllers\TaskController::class, 'status'])->middleware(['auth', 'verified'])->name('tasks.update.status');
Route::delete('/tasks/{task}', [App\Http\Controllers\TaskController::class, 'destroy'])->middleware(['auth', 'verified'])->name('tasks.delete');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
