<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\FileScannerController;
use App\Http\Controllers\EmailScannerController;
use App\Http\Controllers\UrlScannerController;

// Dashboard
Route::view('/', 'dashboard.index')->name('dashboard');

// Scanner Pages
Route::get('/url-scanner', [UrlScannerController::class, 'showScanner'])->name('scanner.url');
Route::post('/url-scanner', [UrlScannerController::class, 'doScan'])->name('scanner.url.submit');

Route::view('/file-scanner', 'scanner.filescanner')->name('scanner.file');
Route::post('/file-scanner', [FileScannerController::class, 'scan'])->name('scanner.file.submit');

Route::get('/email-scanner', [EmailScannerController::class, 'showForm'])->name('scanner.email');
Route::post('/email-scanner', [EmailScannerController::class, 'submit'])->name('scanner.email.submit');

Route::get('/result/safe/{scan_id}', [ResultController::class, 'safe'])->name('result.safe');
Route::get('/result/suspicious/{scan_id}', [ResultController::class, 'suspicious'])->name('result.suspicious');
Route::get('/result/notsafe/{scan_id}', [ResultController::class, 'notsafe'])->name('result.notsafe');
Route::get('/result/full/{scan_id}', [ResultController::class, 'full'])->name('result.full');
Route::post('/comment', [ResultController::class, 'storeComment'])->name('comment.store');

// Scan Result Pages
// Route::view('/result-safe', 'result.safe')->name('result.safe');
// Route::view('/result-unsafe', 'result.notsafe')->name('result.notsafe');
// Route::view('/result-suspicious', 'result.suspicious')->name('result.suspicious');
// Route::view('/full-report', 'result.fullreport')->name('result.full');
Route::get('/result/{status}', [ResultController::class, 'show'])->name('result.show');

// History Page
Route::view('/history', 'history.index')->name('history');

// Authentication Pages

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegister'])->name('show.register');
Route::post('/register', [RegisterController::class, 'register'])->name('register');
