<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\InvoiceController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('vouchers', VoucherController::class)->middleware('auth');
Route::resource('invoices', InvoiceController::class)->middleware('auth');

Route::post('precio_ajax_b', [VoucherController::class, 'precio_ajax_b'])->name('precio_ajax_b');
Route::post('precio_ajax_f', [InvoiceController::class, 'precio_ajax_f'])->name('precio_ajax_f');