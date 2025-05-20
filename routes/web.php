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
Route::prefix('dashboard')->group(function() {
    Route::get('/list_document', 'MainController@list_document')->name('list_document');
    Route::get('/list_document/{id}', 'MainController@detail_list_document')->name('detail_list_document');
    Route::post('/list_document/{id}', 'MainController@submit_detail_list_document')->name('submit_detail_list_document');
    Route::get('/print_document/{id}', 'MainController@print_document')->name('print_document');
    Route::post('/new_doc/{id}', 'MainController@new_doc')->name('new_doc');
    Route::get('/export_csv', 'MainController@export_csv');
});
Route::prefix('admin')->group(function () {
    Route::get('/manage_users', 'AdminController@manage_users')->name('manage_users');
    Route::get('/detail_users/{id?}', 'AdminController@detail_users')->name('detail_users');
    Route::post('/detail_users/{id?}', 'AdminController@submit_users');
    Route::post('/delete_users/{id}', 'AdminController@delete_users');
    Route::get('/manage_sow', 'AdminController@manage_sow')->name('manage_sow');
    Route::get('/detail_sow/{id?}', 'AdminController@detail_sow')->name('detail_sow');
    Route::post('/detail_sow/{id?}', 'AdminController@submit_sow');
    Route::post('/delete_sow/{id}', 'AdminController@delete_sow');
    Route::get('/upload_spmk', 'AdminController@upload_spmk')->name('upload_spmk');
    Route::post('/upload_spmk', 'AdminController@submit_upload_spmk');
    Route::post('/deactivate_pid/{id}', 'AdminController@deactivate_pid');
    Route::prefix('api')->group(function () {
        Route::post('/get_list_manage_users', 'AdminController@get_list_manage_users');
        Route::post('/get_list_manage_sow', 'AdminController@get_list_manage_sow');
    });
});