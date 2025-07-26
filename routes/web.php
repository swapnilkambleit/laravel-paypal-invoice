<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\PayPalController::class, 'index']);
Route::get('invoice-list', [App\Http\Controllers\PayPalController::class, 'index'])->name('invoice-list');
Route::get('invoice-create', [App\Http\Controllers\PayPalController::class, 'invoiceCreate'])->name('invoice-create');
Route::post('invoice', [App\Http\Controllers\PayPalController::class, 'invoiceCreateSubmit']);
Route::get('invoice-delete/{slug}', [App\Http\Controllers\PayPalController::class, 'invoiceDelete'])->name('invoice-delete');