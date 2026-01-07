<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;

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

Route::get('/admin/booking_management', function () {
    return 'ยินดีต้อนรับแอดมิน 🎉';
})->name('admin.booking_management');