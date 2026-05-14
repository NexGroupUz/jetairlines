<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');

Route::get('/equipment', [PageController::class, 'equipment'])->name('equipment');

Route::get('/policy', [PageController::class, 'policy'])->name('policy');
Route::get('/agreement', [PageController::class, 'agreement'])->name('agreement');
Route::get('/offer', [PageController::class, 'offer'])->name('offer');

Route::get('/checkout/{slug}', [PaymentController::class, 'checkout'])->name('payment.checkout');
Route::post('/payment/create', [PaymentController::class, 'create'])->name('payment.create');

Route::get('/payment/{order}/octo/return', [PaymentController::class, 'octoReturn'])->name('payment.octo.return');
Route::post('/payment/octo/notify', [PaymentController::class, 'octoNotify'])->name('payment.octo.notify');

Route::get('/payment/{order}/pending', [PaymentController::class, 'pending'])->name('payment.pending');
Route::get('/payment/{order}/status', [PaymentController::class, 'status'])->name('payment.status');
Route::get('/payment/{order}/failed', [PaymentController::class, 'failed'])->name('payment.failed');