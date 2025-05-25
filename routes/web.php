<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\FileScannerController;
use App\Http\Controllers\UrlScannerController;

// Dashboard
Route::view('/', 'dashboard.index')->name('dashboard');

// Scanner Pages
Route::get('/url-scanner', [UrlScannerController::class, 'showScanner'])->name('scanner.url');
Route::view('/file-scanner', 'scanner.filescanner')->name('scanner.file');
Route::post('/file-scanner', [FileScannerController::class, 'scan'])->name('scanner.file.submit');
Route::view('/email-scanner', 'scanner.emailscanner')->name('scanner.email');

// Scan Result Pages
//Route::view('/result-safe', 'result.safe')->name('result.safe');
//Route::view('/result-unsafe', 'result.notsafe')->name('result.unsafe');
Route::view('/full-report', 'result.fullreport')->name('result.full');
Route::get('/result/{status}', [ResultController::class, 'show'])->name('result.show');

// History Page
Route::view('/history', 'history.index')->name('history');

// Authentication Pages

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegister'])->name('show.register');
Route::post('/register', [RegisterController::class, 'register'])->name('register');
