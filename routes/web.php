<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\NotebookController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserBorrowController;
use App\Http\Controllers\AdminBorrowController;
use App\Http\Controllers\AdminPrinterController;
use App\Http\Controllers\PrinterBorrowController;
use App\Http\Controllers\AdminPrinterBorrowController;

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
Route::post('/admin/borrow/confirm-return/{id}', [AdminBorrowController::class,'confirmReturn'])
    ->name('admin.borrow.confirm_return');


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

Route::get('/admin/users/{id}/edit', [AdminUserController::class, 'edit'])
    ->name('admin.user.edit');

Route::put('/admin/users/{id}', [AdminUserController::class, 'update'])
    ->name('admin.user.update');

Route::delete('/admin/users/{id}', [AdminUserController::class, 'destroy'])
    ->name('admin.user.delete');
    
//---------------------admin borrow history-----------------------//
Route::get('/admin/borrow_history', [AdminBorrowController::class, 'history'])
    ->name('admin.borrow_history');

//---------------------admin คืนเครื่องยืมโน๊ตบุ้ค-----------------------//
Route::get('/admin/return_management', [AdminBorrowController::class, 'returnList'])
    ->name('admin.return_management');

Route::post('/admin/return_management/{id}/confirm', [AdminBorrowController::class, 'confirmReturn'])
    ->name('admin.borrow.confirm_return');
Route::post('/admin/printer/confirm-return/{id}', [AdminPrinterBorrowController::class, 'confirmReturn'])
    ->name('admin.printer.confirm_return');


Route::prefix('admin')->group(function () {
    Route::get('/printers', [AdminPrinterController::class, 'index'])->name('admin.printers.index');
    Route::post('/printers', [AdminPrinterController::class, 'store'])->name('admin.printers.store');
    Route::get('/printers/{id}/edit', [AdminPrinterController::class, 'edit'])->name('admin.printers.edit');
    Route::put('/printers/{id}', [AdminPrinterController::class, 'update'])->name('admin.printers.update');
    Route::delete('/printers/{id}', [AdminPrinterController::class, 'destroy'])->name('admin.printers.destroy');

    // Admin Printer Borrow Management
    Route::get('/printer_borrow_management', [AdminPrinterBorrowController::class, 'index'])
        ->name('admin.printer.borrow_management');

    Route::post('/printer_borrow/approve/{id}', [AdminPrinterBorrowController::class, 'approve'])
        ->name('admin.printer.borrow.approve');

    Route::post('/printer_borrow/reject/{id}', [AdminPrinterBorrowController::class, 'reject'])
        ->name('admin.printer.borrow.reject');
});



//===================== user routes =====================//

Route::middleware(['auth'])->group(function () {

    //---------------------user notebook request-----------------------//
    // ขอจอง / ยืมโน้ตบุ๊ก
    Route::get('/user/notebook_request', [UserBorrowController::class, 'index'])
        ->name('user.notebook_request');

    Route::post('/user/borrow', [UserBorrowController::class, 'store'])
        ->name('user.borrow.store');

    // คืนเครื่องฝั่งผู้ใช้งาน
    // Route::post('/user/return/{id}', [UserBorrowController::class, 'returnNotebook'])
    //     ->name('user.borrow.return');

    //---------------------user borrow list-----------------------//
    Route::get('/user/borrow_list', [UserBorrowController::class, 'borrowList'])
        ->name('user.borrow_list');

    //---------------------user borrow history-----------------------//
    Route::get('/user/borrow_history', [UserBorrowController::class, 'borrowHistory'])
        ->name('user.borrow_history');

    //---------------------user profile-----------------------//
    Route::get('/user/profile', function () {
        return view('user.profile');
    })->name('user.profile');

    // หน้าแสดงเครื่องปริ้นให้ยืม
    Route::get('/printers', [PrinterBorrowController::class, 'index'])->name('user.printers.index');

    // กดยืมเครื่องปริ้น
    Route::post('/printers/borrow', [PrinterBorrowController::class, 'borrow'])->name('user.printers.borrow');

    // ดูประวัติการยืม
    Route::get('/printers/history', [PrinterBorrowController::class, 'history'])->name('user.printers.history');
});
