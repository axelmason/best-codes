<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CodeController;
use App\Http\Controllers\ModerateController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ShopApiController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');

Route::get('/shops/top', [ShopController::class, 'top']);
Route::get('/shop/{shop_alias}', [ShopController::class, 'get']);
Route::get('/shop/{shop_id}/related', [ShopController::class, 'getRelated']);

Route::get('code/{code_id}', [CodeController::class, 'details'])->name('details');
Route::put('code/{code_id}/view', [CodeController::class, 'view'])->middleware('throttle:view');
Route::put('code/{code_id}/use', [CodeController::class, 'use'])->middleware('throttle:use');
Route::get('/notifications', [NotificationController::class, 'get']);
Route::put('/notifications/{id}', [NotificationController::class, 'put']);
Route::post('/notifications', [NotificationController::class, 'create']);

Route::middleware('guest')->group(function () {
    Route::post('/users/login', [UserController::class, 'login'])->name('login');
    Route::post('/users/register', [UserController::class, 'register'])->name('register');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
});

Route::middleware(['role:admin,moderator'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('codes/page', [CodeController::class, 'adminPage'])->name('codes.adminPage');
    Route::get('shops/page', [ShopController::class, 'adminPage'])->name('shops.adminPage');
    Route::get('employees/page', [ModerateController::class, 'adminPage'])->name('employees.adminPage');
    Route::get('codes/moderate', [ModerateController::class, 'moderatePage'])->name('codes.moderatePage');
});

Route::middleware('role:admin,moderator')->group(function () {
    Route::get('/shops/all', [ShopApiController::class, 'all']);
    Route::resource('codes', CodeController::class);
    Route::resource('shops', ShopApiController::class);
    Route::post('codes/{id}/images/upload', [CodeController::class, 'uploadImages']);
    Route::post('codes/{id}/images/delete', [CodeController::class, 'deleteImages']);
    Route::get('codes/{id}/images/fetch', [CodeController::class, 'fetchImages']);

    Route::get('shops/types', [ShopController::class, 'getTypes']);
    Route::get('moderate', [ModerateController::class, 'list'])->name('moderate');

    Route::get('moderators/list', [ModerateController::class, 'employeesList']);
    Route::post('moderators/set', [ModerateController::class, 'setNewModerator']);
    Route::post('moderators/unset', [ModerateController::class, 'unsetModerator']);
    // Route::get('moderate/open/{code_id}', [ModerateController::class, 'open'])->name('open');
    Route::put('moderate/{code_id}/edit', [ModerateController::class, 'update']);

});

