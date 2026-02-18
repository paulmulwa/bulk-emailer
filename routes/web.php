<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailController;

Route::get('/', function () {
return view('emails.index');
});


Route::get('/emails', [EmailController::class, 'index'])->name('emails.index');
Route::post('/emails/store', [EmailController::class, 'store'])->name('emails.store');
Route::get('/emails/create', [EmailController::class, 'create'])->name('emails.create');
Route::post('/emails/send', [EmailController::class, 'sendBulkEmail'])->name('emails.sendBulk');



// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
