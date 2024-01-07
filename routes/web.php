<?php

use App\Http\Controllers\MedicineController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\LetterTypeController;
use App\Http\Controllers\LetterController;
use Illuminate\Support\Facades\Route;

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

Route::middleware('IsGuest')->group(function(){
    Route::get('/', function(){
        return view('login');
    })->name('login');
    Route::post('home.page', [UserController::class, 'loginAuth'])->name('login.auth');
});

Route::get('/logout', [UserController::class, 'logout'])->name('logout');
Route::get('/error-permission', function () {
    return view('errors.permission');
})->name('error.permission');

Route::middleware(['IsLogin', 'IsStaff'])->group(function(){
    Route::prefix('/user')->name('user.')->group(function() {
        Route::get('/create', [UserController::class, 'create'])->name('create'); 
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/', [UserController::class, 'index'])->name('home');
        Route::get('/{id}', [UserController::class, 'edit'])->name('edit');
        Route::patch('/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('delete');
    });
    Route::prefix('/staff')->name('staff.')->group(function() {
        Route::get('/create', [StaffController::class, 'create'])->name('create'); 
        Route::post('/store', [StaffController::class, 'store'])->name('store');
        Route::get('/', [StaffController::class, 'index'])->name('home');
        Route::get('/{id}', [StaffController::class, 'edit'])->name('edit');
        Route::patch('/{id}', [StaffController::class, 'update'])->name('update');
        Route::delete('/{id}', [StaffController::class, 'destroy'])->name('delete');
    });
    Route::prefix('/guru')->name('guru.')->group(function() {
        Route::get('/create', [GuruController::class, 'create'])->name('create'); 
        Route::post('/store', [GuruController::class, 'store'])->name('store');
        Route::get('/', [GuruController::class, 'index'])->name('home');
        Route::get('/{id}', [GuruController::class, 'edit'])->name('edit');
        Route::patch('/{id}', [GuruController::class, 'update'])->name('update');
        Route::delete('/{id}', [GuruController::class, 'destroy'])->name('delete');
    });
    Route::prefix('/klasifikasi')->name('klasifikasi.')->group(function () {
        Route::get('/', [LetterTypeController::class, 'index'])->name('home');
        Route::get('/create', [LetterTypeController::class, 'create'])->name('create');
        Route::post('/store', [LetterTypeController::class, 'store'])->name('store');
        Route::get('/show/{id}', [LetterTypeController::class, 'show'])->name('show');
        Route::get('/edit/{id}', [LetterTypeController::class, 'edit'])->name('edit');
        Route::patch('/update/{id}', [LetterTypeController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [LetterTypeController::class, 'destroy'])->name('destroy');
        Route::get('/print/{id}', [LetterTypeController::class, 'show'])->name('print');
        Route::get('/download/{id}', [LetterTypeController::class, 'downloadPDF'])->name('download');
        Route::get('/export/pdf', [LetterController::class, 'export'])->name('export');
    });
    Route::prefix('/surat')->name('surat.')->group(function() {
        Route::get('/', [LetterController::class, 'index'])->name('home');
        Route::get('/create', [LetterController::class, 'create'])->name('create');
        Route::post('/store', [LetterController::class, 'store'])->name('store');
        Route::get('/{id}', [LetterController::class, 'edit'])->name('edit');
        Route::patch('/{id}', [LetterController::class, 'update'])->name('update');
        Route::delete('/{id}', [LetterController::class, 'destroy'])->name('delete');
        Route::get('/print/{id}', [LetterController::class, 'show'])->name('print');
        Route::get('/show/{id}', [LetterController::class, 'show'])->name('show');
        Route::get('/download/{id}', [LetterController::class, 'downloadPDF'])->name('download');
        Route::get('/export/pdf', [LetterController::class, 'export'])->name('export');
    });
});



Route::middleware(['IsLogin'])->group(function(){
    Route::any('/home', function(){
        return view('home');
    })->name('home.page');
});