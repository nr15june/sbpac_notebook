<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\NotebookController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserBorrowController;
use App\Http\Controllers\AdminBorrowController;

// Route::get('/', function () {
//     return view('welcome');
// });

//---------------------login-----------------------//

Route::get('/', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.submit');

//---------------------logout-----------------------//
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

//===================== admin routes =====================//

//---------------------admin borrow management-----------------------//
Route::get('/admin/borrow_management', [AdminBorrowController::class, 'index'])
    ->name('admin.borrow_management');

Route::post('/admin/borrow_management/{id}/approve', [AdminBorrowController::class, 'approve'])
    ->name('admin.borrow.approve');

Route::post('/admin/borrow_management/{id}/reject', [AdminBorrowController::class, 'reject'])
    ->name('admin.borrow.reject');

//---------------------admin notebook management-----------------------//
Route::get('/admin/notebooks', [NotebookController::class, 'index'])
    ->name('admin.notebook_management');

Route::post('/admin/notebooks', [NotebookController::class, 'store'])
    ->name('admin.notebooks.store');

Route::get('/admin/notebooks/{id}/edit', [NotebookController::class, 'edit'])
    ->name('admin.notebooks.edit');

Route::delete('/admin/notebooks/{id}', [NotebookController::class, 'destroy'])
    ->name('admin.notebooks.delete');

//---------------------admin user management-----------------------//
Route::get('/user_management', [AdminUserController::class, 'index'])
    ->name('admin.user_management');

Route::get('/user_management/create', [AdminUserController::class, 'create'])
    ->name('admin.user.create');

Route::post('/user_management/store', [AdminUserController::class, 'store'])
    ->name('admin.user.store');

//---------------------admin borrow history-----------------------//
Route::get('/admin/borrow_history', [AdminBorrowController::class,'history'])
    ->name('admin.borrow_history');



//===================== user routes =====================//

Route::middleware(['auth'])->group(function () {

    //---------------------user notebook request-----------------------//
    // ขอจอง / ยืมโน้ตบุ๊ค
    Route::get('/user/notebook_request', [UserBorrowController::class, 'index'])
        ->name('user.notebook_request');

    Route::post('/user/borrow', [UserBorrowController::class, 'store'])
        ->name('user.borrow.store');

    // คืนเครื่อง
    Route::post('/user/return/{id}', [UserBorrowController::class, 'returnNotebook'])
    ->name('user.borrow.return');

    //---------------------user borrow list-----------------------//
    Route::get('/user/borrow_list', [UserBorrowController::class, 'borrowList'])
        ->name('user.borrow_list');

    //---------------------user borrow history-----------------------//
    Route::get('/user/borrow_history', [UserBorrowController::class,'borrowHistory'])
    ->name('user.borrow_history');

    //---------------------user profile-----------------------//
    Route::get('/user/profile', function () {
        return view('user.profile');
    })->name('user.profile');
});
