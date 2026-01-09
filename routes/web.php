<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminUserController;


// Route::get('/', function () {
//     return view('welcome');
// });

//---------------------login-----------------------//

Route::get('/', function () {
    return view('login');
});

Route::get('/login', [AdminAuthController::class, 'showLoginForm'])
    ->name('admin.login');

Route::post('/login', [AdminAuthController::class, 'login'])
    ->name('admin.login.submit');

//---------------------admin booking management-----------------------//
Route::get('/admin/booking_management', function () {
    return view('admin.booking_management');
})->name('admin.booking_management');

//---------------------admin notebook management-----------------------//
Route::get('/admin/notebook_management', function () {
    return view('admin.notebook_management');
})->name('admin.notebook_management');

//---------------------admin user management-----------------------//
Route::get('/admin/user_management', function () {
    return view('admin.user_management');
})->name('admin.user_management');

Route::get('/admin/user_management', [AdminUserController::class, 'index'])
    ->name('admin.user_management');
    
Route::get('/admin/user_management/create', [AdminUserController::class, 'create'])
    ->name('admin.user.create');

Route::post('/admin/user_management/store', [AdminUserController::class, 'store'])
    ->name('admin.user.store');
