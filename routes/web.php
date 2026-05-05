<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');

Route::get('/policy', [PageController::class, 'policy'])->name('policy');
Route::get('/agreement', [PageController::class, 'agreement'])->name('agreement');
Route::get('/offer', [PageController::class, 'offer'])->name('offer');

Route::get('/checkout/{slug}', [PaymentController::class, 'checkout'])->name('payment.checkout');
Route::post('/payment/create', [PaymentController::class, 'create'])->name('payment.create');

Route::get('/payment/{order}/card', [PaymentController::class, 'card'])->name('payment.card');
Route::post('/payment/{order}/pre-apply', [PaymentController::class, 'preApply'])->name('payment.pre_apply');

Route::get('/payment/{order}/otp', [PaymentController::class, 'otp'])->name('payment.otp');
Route::post('/payment/{order}/apply', [PaymentController::class, 'apply'])->name('payment.apply');

Route::get('/payment/{order}/success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/{order}/failed', [PaymentController::class, 'failed'])->name('payment.failed');