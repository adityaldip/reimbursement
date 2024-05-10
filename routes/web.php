<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('login');
})->name('login');

Route::post('/login-proses', [LoginController::class, 'loginproses'])->name('login.proses');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth']], function() {
    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function() {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/tambah-user-form', [AdminController::class, 'formTambahUser'])->name('user.tambah');
        Route::post('/tambah-user-proses', [AdminController::class, 'tambahUser'])->name('user.tambah.proses');

        Route::get('/edit-user-form/{id}', [AdminController::class, 'formEditUser'])->name('user.edit');
        Route::post('/edit-user-proses', [AdminController::class, 'updateUser'])->name('user.update.proses');

        Route::post('/hapus-user', [AdminController::class, 'deleteUser'])->name('user.hapus');

        Route::get('/tambah-reimbursement', [AdminController::class, 'formReimbursement'])->name('reimbursement.tambah');
        Route::post('/tambah-reimbursement-proses', [AdminController::class, 'tambahReimbursement'])->name('reimbursement.tambah.proses');

        Route::post('/reimbursement/aprrove', [AdminController::class, 'aprroveReimbursement'])->name('reimbursement.approve');
        Route::post('/reimbursement/reject', [AdminController::class, 'rejectReimbursement'])->name('reimbursement.reject');

    });
});