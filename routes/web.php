<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\FileScannerController;
use App\Http\Controllers\EmailScannerController;
use App\Http\Controllers\UrlScannerController;
use App\Http\Controllers\PreventController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\CommentController;

// Dashboard
Route::view('/', 'dashboard.index')->name('dashboard');

// Scanner Pages
Route::get('/url-scanner', [UrlScannerController::class, 'showScanner'])->name('scanner.url');
Route::post('/url-scanner', [UrlScannerController::class, 'doScan'])->name('scanner.url.submit');

Route::get('/file-scanner', [FileScannerController::class, 'index'])->name('scanner.file');
Route::post('/file-scanner', [FileScannerController::class, 'scan'])->name('scanner.file.submit');


Route::get('/email-scanner', [EmailScannerController::class, 'showForm'])->name('scanner.email');
Route::post('/email-scanner', [EmailScannerController::class, 'submit'])->name('scanner.email.submit');

Route::get('/result/safe/{scan_id}', [ResultController::class, 'safe'])->name('result.safe');
Route::get('/result/suspicious/{scan_id}', [ResultController::class, 'suspicious'])->name('result.suspicious');
Route::get('/result/notsafe/{scan_id}', [ResultController::class, 'notsafe'])->name('result.notsafe');
Route::get('/result/full/{scan_id}', [ResultController::class, 'full'])->name('result.full');
Route::post('/comment', [ResultController::class, 'storeComment'])->name('comment.store');

Route::middleware(['auth'])->group(function () {
    Route::get('/history', [HistoryController::class, 'history'])->name('scan.history');
    Route::get('/result/full/{scan_id}', [HistoryController::class, 'full'])->name('result.full');
});
// Scan Result Pages
// Route::view('/result-safe', 'result.safe')->name('result.safe');
// Route::view('/result-unsafe', 'result.notsafe')->name('result.notsafe');
// Route::view('/result-suspicious', 'result.suspicious')->name('result.suspicious');
// Route::view('/full-report', 'result.fullreport')->name('result.full');
Route::get('/result/{status}', [ResultController::class, 'show'])->name('result.show');
Route::post('/comments', [CommentController::class, 'store'])->middleware('auth');
// Authentication Pages

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegister'])->name('show.register');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/prevent', [PreventController::class, 'index'])->name('prevent.index');
// Preventive education pages
Route::view('/prevent/phishing', 'result.prevent.phishing')->name('prevent.phishing');
Route::view('/prevent/already-clicked', 'result.prevent.alreadyclicked')->name('prevent.clicked');
Route::view('/prevent/cyber-hygiene', 'result.prevent.cyberhygiene')->name('prevent.cyberhygiene');
Route::view('/prevent/exe-dangers', 'result.prevent.exerisks')->name('prevent.exerisks');
Route::view('/prevent/eml-threats', 'result.prevent.emlthreats')->name('prevent.emlthreats');
Route::view('/prevent/url-attacks', 'result.prevent.urlattacks')->name('prevent.urlattacks');
Route::view('/prevent/fake-emails', 'result.prevent.fakeemails')->name('prevent.fakeemails');
Route::view('/prevent/general-tips', 'result.prevent.generaltips')->name('prevent.generaltips');

