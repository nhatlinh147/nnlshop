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

Route::get('/dang-nhap', 'LoginController@login_by_auth')->name('backend.login_by_auth');
Route::post('/kiem-tra-dang-nhap', 'LoginController@check_login')->name('backend.check_login');
Route::post('/luu-dang-ky', 'LoginController@save_register')->name('backend.save_register');
Route::get('/dang-ky', 'LoginController@register_by_auth')->name('backend.register_by_auth');