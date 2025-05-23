<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

// Dashboard
Route::view('/', 'dashboard.index')->name('dashboard');

// Scanner Pages
Route::view('/url-scanner', 'scanner.urlscanner')->name('scanner.url');
Route::view('/file-scanner', 'scanner.filescanner')->name('scanner.file');
Route::view('/email-scanner', 'scanner.emailscanner')->name('scanner.email');

// Scan Result Pages
//Route::view('/result-safe', 'result.safe')->name('result.safe');
//Route::view('/result-unsafe', 'result.notsafe')->name('result.unsafe');
Route::view('/full-report', 'result.fullreport')->name('result.full');
Route::get('/result/{status}', [ResultController::class, 'show'])->name('result.show');

// History Page
Route::view('/history', 'history.index')->name('history');

// Authentication Pages
Route::get('/login', [LoginController::class, 'showLogin'])->name('show.login');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/register', [RegisterController::class, 'showRegister'])->name('show.register');
Route::post('/register', [RegisterController::class, 'register'])->name('register');
