<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CodeController;
use App\Http\Controllers\ModerateController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('code/{code_id}', [CodeController::class, 'details'])->name('details');
Route::put('code/{code_id}/viewed', [CodeController::class, 'viewed']);
Route::get('/notifications', [NotificationController::class, 'get']);
Route::put('/notifications/{id}', [NotificationController::class, 'put']);
Route::post('/notifications', [NotificationController::class, 'create']);

Route::middleware('guest')->group(function () {
    Route::post('/users/login', [UserController::class, 'login'])->name('login');
    Route::post('/users/register', [UserController::class, 'register'])->name('register');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/suggest', [CodeController::class, 'suggestPage'])->name('suggest');
});

Route::middleware('role:admin')->group(function () {
    Route::get('admin', [AdminController::class, 'index'])->name('admin');
});

Route::middleware('role:admin,moderator')->group(function () {
    Route::resource('codes', CodeController::class);
    Route::get('moderate', [ModerateController::class, 'index'])->name('moderate');
    Route::get('moderate/open/{code_id}', [ModerateController::class, 'open'])->name('open');
    Route::put('moderate/{code_id}/edit', [ModerateController::class, 'update']);
});
