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
Route::get('/dashboard/main_board', 'MainController@main_board')->name('main_board');
Route::get('/dashboard/main_board_khusus', 'MainController@main_board_khusus')->name('main_board_khusus');
Route::get('/dashboard/main_event/{id}', 'MainController@main_event')->name('main_event');
// ADMIN
Route::get('/admin/manage_admin', 'MainController@manage_admin')->name('manage_admin');
Route::get('/admin/add_admin/{id?}', 'MainController@add_admin')->name('add_admin');
Route::post('/admin/add_admin/{id?}', 'MainController@submit_admin');
Route::post('/admin/delete_admin/{id}', 'MainController@delete_admin');
Route::get('/admin/manage_peserta', 'MainController@manage_peserta')->name('manage_peserta');
Route::get('/admin/add_peserta/{id?}', 'MainController@add_peserta')->name('add_peserta');
Route::post('/admin/add_peserta/{id?}', 'MainController@submit_peserta');
Route::post('/admin/delete_peserta/{id}', 'MainController@delete_peserta');
Route::get('/admin/download_excel', 'MainController@download_excel');
Route::get('/admin/download_excel_list/{date}', 'MainController@download_excel_list');
Route::get('/admin/manage_peserta_event', 'MainController@manage_peserta_event')->name('manage_peserta_event');
Route::get('/admin/add_peserta_event/{id?}', 'MainController@add_peserta_event')->name('add_peserta_event');
Route::post('/admin/add_peserta_event/{id?}', 'MainController@submit_peserta_event');
Route::post('/admin/delete_peserta_event/{id}', 'MainController@delete_peserta_event');
// ABSEN
Route::get('/absen', 'AbsenController@absen')->name('absen');
Route::post('/absen', 'AbsenController@submit_absen');
Route::get('/absen_event/{id}', 'AbsenController@absen_event')->name('absen_event');
Route::post('/absen_event/{id}', 'AbsenController@submit_absen_event');
// API
Route::post('/api/reset_absen', 'MainController@reset_absen')->name('reset_absen');
Route::post('/api/reset_absen_event/{id}', 'MainController@reset_absen_event')->name('reset_absen_event');
