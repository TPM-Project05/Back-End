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

Route::get('/leader-form', [LeaderController::class,'showForm'])->name('leader.form');
Route::post('/submit-leader-data', [LeaderController::class, 'submitLeaderData'])->name('leader.submit');
require __DIR__.'/auth.php';
