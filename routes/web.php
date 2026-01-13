<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\NotebookController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserBorrowController;

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

//---------------------admin borrow management-----------------------//
Route::get('/admin/borrow_management', function () {
    return view('admin.borrow_management');
})->name('admin.borrow_management');

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
Route::get('/admin/user_management', function () {
    return view('admin.user_management');
})->name('admin.user_management');

Route::get('/admin/user_management', [AdminUserController::class, 'index'])
    ->name('admin.user_management');

Route::get('/admin/user_management/create', [AdminUserController::class, 'create'])
    ->name('admin.user.create');

Route::post('/admin/user_management/store', [AdminUserController::class, 'store'])
    ->name('admin.user.store');

//---------------------admin borrow history-----------------------//
Route::get('/admin/borrow_history', function () {
    return view('admin.borrow_history');
})->name('admin.borrow_history');

Route::middleware(['auth'])->group(function () {
    //---------------------user notebook request-----------------------//
    Route::get('/user/notebook_request', [UserBorrowController::class, 'index'])
        ->name('user.notebook_request');

    Route::post('/user/borrow', [UserBorrowController::class, 'store'])
        ->name('user.borrow.store');

    //---------------------user borrow list-----------------------//
    Route::get('/user/borrow_list', function () {
        return view('user.borrow_list');
    })->name('user.borrow_list');

    //---------------------user borrow history-----------------------//
    Route::get('/user/borrow_history', function () {
        return view('user.borrow_history');
    })->name('user.borrow_history');

    //---------------------user report problem-----------------------//
    Route::get('/user/report_problem', function () {
        return view('user.report_problem');
    })->name('user.report_problem');

    //---------------------user profile-----------------------//
    Route::get('/user/profile', function () {
        return view('user.profile');
    })->name('user.profile');
});
