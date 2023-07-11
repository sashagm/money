<?php

use Illuminate\Support\Facades\Route;
use Sashagm\Money\Http\Controllers\TransferController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::post('/transfer/send', [TransferController::class, 'send'])->name('transfer.send');
Route::post('/transfer/abort', [TransferController::class, 'abort'])->name('transfer.abort');
