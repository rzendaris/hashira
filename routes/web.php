<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CMS\DashboardController;
use App\Http\Controllers\CMS\UserController;
use App\Http\Controllers\CMS\StudentController;
use App\Http\Controllers\CMS\PaymentController;
use App\Http\Controllers\CMS\ConfigurationController;
use App\Http\Controllers\CMS\StudentReportController;

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

Route::get('login', [LoginController::class, 'login'])->name('login');
Route::post('actionlogin', [LoginController::class, 'actionlogin'])->name('actionlogin');

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');
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
    Route::post('/admin/students/update', [StudentController::class, 'update'])->name('location-view');

    Route::get('/admin/student-report', [StudentReportController::class, 'index'])->name('student-report-view');
    Route::post('/admin/student-report/create', [StudentReportController::class, 'create'])->name('student-report-create');
    Route::post('/admin/student-report/score', [StudentReportController::class, 'createReportScore'])->name('student-report-score');

    Route::get('/admin/potential-students', [StudentController::class, 'potentialStudent'])->name('potential-student-view');
    Route::post('/admin/potential-students/create', [StudentController::class, 'potentialStudentCreate'])->name('potential-student-create');

    Route::get('/admin/configurations/location', [ConfigurationController::class, 'indexLocation'])->name('location-view');
    Route::post('/admin/configurations/location/create', [ConfigurationController::class, 'createLocation'])->name('location-create');
    Route::post('/admin/configurations/location/update', [ConfigurationController::class, 'updateLocation'])->name('location-update');
    Route::get('/admin/configurations/batch', [ConfigurationController::class, 'indexBatch'])->name('batch-view');
    Route::post('/admin/configurations/batch/create', [ConfigurationController::class, 'createBatch'])->name('batch-create');

    Route::get('/admin/invoice', [PaymentController::class, 'invoice'])->name('invoice-view');
    Route::get('/invoice/{payment_id}', [PaymentController::class, 'invoicePDF'])->name('invoice-pdf');
});