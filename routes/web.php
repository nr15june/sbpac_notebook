<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\NotebookController;

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
Route::get('/admin/notebooks', [NotebookController::class,'index'])
    ->name('admin.notebook_management');

Route::post('/admin/notebooks', [NotebookController::class,'store'])
    ->name('admin.notebooks.store');
    
Route::get('/admin/notebooks/{id}/edit', [NotebookController::class,'edit'])
    ->name('admin.notebooks.edit');

Route::delete('/admin/notebooks/{id}', [NotebookController::class,'destroy'])
    ->name('admin.notebooks.delete');

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
