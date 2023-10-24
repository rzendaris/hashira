<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CMS\DashboardController;
use App\Http\Controllers\CMS\UserController;
use App\Http\Controllers\CMS\StudentController;
use App\Http\Controllers\CMS\PaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [LoginController::class, 'login'])->name('login');
Route::post('actionlogin', [LoginController::class, 'actionlogin'])->name('actionlogin');

Route::middleware(['auth'])->group(function () {
    Route::get('actionlogout', [LoginController::class, 'actionlogout'])->name('actionlogout');
    Route::get('home', [DashboardController::class, 'index'])->name('home');
    Route::get('calendar', [DashboardController::class, 'calendar'])->name('calendar');

    Route::get('/admin/users', [UserController::class, 'index'])->name('user-view');
    Route::post('/admin/users/create', [UserController::class, 'create'])->name('user-create');
    Route::post('/admin/users/update', [UserController::class, 'update'])->name('user-update');

    Route::get('/admin/students', [StudentController::class, 'index'])->name('student-view');
    Route::get('/admin/students/{id}', [StudentController::class, 'detail'])->name('student-detail');
    Route::get('/admin/students/{id}/installment', [StudentController::class, 'detailInstallment'])->name('student-detail-installment');
    Route::post('/admin/students/create', [StudentController::class, 'create'])->name('student-create');
    Route::post('/admin/students/update', [StudentController::class, 'update'])->name('student-update');

    Route::get('/admin/invoice', [PaymentController::class, 'invoice'])->name('invoice-view');
    Route::get('/invoice/{payment_id}', [PaymentController::class, 'invoicePDF'])->name('invoice-pdf');
});