<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JWTAuthController;
use App\Http\Controllers\LeaderController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\JwtMiddleware;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\TeamController;

use App\Http\Controllers\SubscribeController;
use App\Http\Controllers\ContactUsController;


Route::post('/subscribe', [SubscribeController::class, 'store'])->name('subscribe.store');
Route::get('/contact-us', [ContactUsController::class, 'create'])->name('contact_us.create');
Route::post('/contact-us', [ContactUsController::class, 'store'])->name('contact_us.store');
// Route untuk user yang belum login
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [JWTAuthController::class, 'register'])->withoutMiddleware('jwt.auth');
    Route::post('login', [JWTAuthController::class, 'login'])->withoutMiddleware('jwt.auth');
    
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

// Route untuk user yang sudah login
Route::middleware('auth:api')->group(function () {
    // Route::get('profile', [ProfileController::class, 'profile']);
    Route::get('refresh', [JWTAuthController::class, 'refresh']);
    
    // Verifikasi email
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
    
    // Konfirmasi password
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
    
    // Update password
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');
});

Route::middleware([JwtMiddleware::class])->group(function(){
    Route::get('/leaders/create', [LeaderController::class, 'create'])->name('auth.leaders');
    Route::post('/leaders', [LeaderController::class, 'store'])->name('leaders.store');
    Route::get('/members/create', [MemberController::class, 'create'])->name('auth.members');
    Route::post('/members', [MemberController::class, 'store'])->name('members.store');
    Route::get('/user', [JWTAuthController::class, 'getUser']);
    Route::post('/logout', [JWTAuthController::class, 'logout']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::get('/files/cv/{filename}', function ($filename) {
    $path = public_path("storage/cv/{$filename}");

    if (!file_exists($path)) {
        abort(404, 'File tidak ditemukan');
    }

    return response()->download($path);
})->middleware();

Route::get('/files/flazz_card/{filename}', function ($filename) {
    $path = public_path("storage/flazz_card/{$filename}");

    if (!file_exists($path)) {
        abort(404, 'File tidak ditemukan');
    }

    return response()->download($path);
})->middleware();



Route::middleware([JwtMiddleware::class, AdminMiddleware::class])->group(function () {
    Route::put('/admin/members/{id}', [AdminController::class, 'updateMember']);
    Route::put('/admin/teams/{id}', [AdminController::class, 'editTeam']);
    Route::put('/admin/leaders/{id}', [AdminController::class, 'editLeaders']);
    Route::delete('/admin/members/{id}', [AdminController::class, 'deleteMember']);
    Route::delete('/admin/leaders/{id}', [AdminController::class, 'deleteLeader']);
    Route::delete('/admin/team/{id}', [AdminController::class, 'deleteTeam']);
    Route::get('/teams', [TeamController::class, 'index']);
});

