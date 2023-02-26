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

//Login form
Route::get('/dang-nhap', 'CustomerController@sign_in_customer')->name('frontend.sign_in_customer');
Route::get('/dang-ky', 'CustomerController@sign_up_customer')->name('frontend.sign_up_customer');
Route::post('/luu-dang-ky', 'CustomerController@save_register')->name('frontend.save_register');
Route::post('/kiem-tra-dang-nhap', 'CustomerController@check_login')->name('frontend.check_login');