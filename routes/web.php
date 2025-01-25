<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LeaderController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// untuk leader

Route::middleware('auth')->group(function(){
    Route::get('/leaders/create', [LeaderController::class, 'create'])->name('auth.leaders');
    Route::post('/leaders', [LeaderController::class, 'store'])->name('leaders.store');
});

require __DIR__.'/auth.php';
