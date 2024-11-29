<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/login', 'AuthController@login')->name('login');
Route::post('/login', 'AuthController@submit_login');
Route::get('/logout', 'AuthController@logout')->name('logout');
// DASHBOBARD
Route::get('/', 'MainController@base');
Route::get('/dashboard', 'MainController@dashboard')->name('dashboard');
Route::get('/dashboard/list_document', 'MainController@list_document')->name('list_document');
Route::get('/dashboard/list_document/{id}', 'MainController@detail_list_document')->name('detail_list_document');
Route::post('/dashboard/list_document/{id}', 'MainController@submit_detail_list_document')->name('submit_detail_list_document');
Route::post('/dashboard/new_doc/{id}', 'MainController@new_doc')->name('new_doc');
