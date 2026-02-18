<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

Route::middleware('guest')->group(function () {
	Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
	Route::post('/login', [AuthController::class, 'login']);
	Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
	Route::post('/register', [AuthController::class, 'register']);

	// Password reset
	Route::get('/forgot-password', [\App\Http\Controllers\PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
	Route::post('/forgot-password', [\App\Http\Controllers\PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
	Route::get('/reset-password/{token}', [\App\Http\Controllers\PasswordResetController::class, 'showResetForm'])->name('password.reset');
	Route::post('/reset-password', [\App\Http\Controllers\PasswordResetController::class, 'reset'])->name('password.update');
});

Route::middleware('auth')->group(function () {
	Route::get('/', [TaskController::class, 'index']);
	Route::get('/tasks/json', [TaskController::class, 'json']);
	Route::post('/tasks', [TaskController::class, 'store']);
	Route::patch('/tasks/{task}', [TaskController::class, 'update']);
	Route::delete('/tasks/{task}', [TaskController::class, 'destroy']);
	Route::get('/settings', [ProfileController::class, 'show'])->name('settings');
	Route::post('/settings', [ProfileController::class, 'update']);
	Route::post('/settings/password', [ProfileController::class, 'updatePassword']);
	Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});