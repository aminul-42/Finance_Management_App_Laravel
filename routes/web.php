<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SocialMediaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InstallmentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/auth/google', [SocialMediaController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [SocialMediaController::class, 'handleGoogleCallback']);

// Secret Admin Login
Route::get('/admin-secret-login', [AdminController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin-secret-login', [AdminController::class, 'adminLogin'])->name('admin.login.post');

// Admin Routes (protected with admin middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users-overview', [AdminController::class, 'usersOverview'])->name('users.overview');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::patch('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [AdminController::class, 'updateProfile'])->name('profile.update');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
    //Installment Routes
    Route::get('/contributions', [AdminController::class, 'contributions'])->name('contributions.index');
    Route::patch('/contributions/{installment}/approve', [AdminController::class, 'approveContribution'])->name('contributions.approve');
    Route::patch('/contributions/{installment}/reject', [AdminController::class, 'rejectContribution'])->name('contributions.reject');
    Route::get('/profits', [AdminController::class, 'profits'])->name('profits.index');
    Route::post('/profits', [AdminController::class, 'storeProfit'])->name('profits.store');
    Route::patch('/profits/{profit}', [AdminController::class, 'updateProfit'])->name('profits.update');
    Route::delete('/profits/{profit}', [AdminController::class, 'deleteProfit'])->name('profits.delete');
});


// User Routes (protected)
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::get('/password', [UserController::class, 'password'])->name('password');
    Route::post('/password/update', [UserController::class, 'updatePassword'])->name('password.update');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
   // Installment Routes
   Route::get('/installments', [InstallmentController::class, 'index'])->name('installments.index');
    Route::get('/installments/create', [InstallmentController::class, 'create'])->name('installments.create');
    Route::post('/installments', [InstallmentController::class, 'store'])->name('installments.store');
    Route::get('/installments/{installment}/edit', [InstallmentController::class, 'showUpdateForm'])->name('installments.edit');
    Route::put('/installments/{installment}', [InstallmentController::class, 'update'])->name('installments.update');

    
});




