<?php

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

Route::prefix('deposit')->group(function () {
    Route::get('/', 'DepositController@index')->name('deposit.list');
    Route::post('store', 'DepositController@store')->name('deposit.store');
    Route::put('approve/{id}', 'DepositController@approve')->name('deposit.approve');
});
