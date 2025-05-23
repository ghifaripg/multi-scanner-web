<?php

use Illuminate\Support\Facades\Route;

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
Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');
Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');

