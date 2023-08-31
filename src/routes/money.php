<?php

use Illuminate\Support\Facades\Route;
use Sashagm\Money\Http\Controllers\BonusController;
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




Route::group(['middleware' => ['web', 'auth'], 'prefix' => config('money.admin_prefix')], function ()  {
  
    Route::post('/transfer/send', [TransferController::class, 'send'])
    ->name('transfer.send')
    ->middleware('sendMoney');

    Route::post('/transfer/abort', [TransferController::class, 'abort'])
    ->name('transfer.abort')
    ->middleware('abortMoney');


    Route::post('/transfer/bonus', [BonusController::class, 'getBonus'])
    ->name('transfer.bonus')
    ->middleware('getBonus');  

    Route::get('/transfer/bonus/{id}', [BonusController::class, 'customBonus'])
    ->name('transfer.bonus.custom')
    ->middleware('getBonus'); 

});