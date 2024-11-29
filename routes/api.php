<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/get_absen', 'ApiController@get_absen')->name('get_absen');
Route::get('/get_absen_khusus', 'ApiController@get_absen_khusus')->name('get_absen_khusus');
Route::get('/get_absen_event/{id}', 'ApiController@get_absen_event')->name('get_absen_event');
