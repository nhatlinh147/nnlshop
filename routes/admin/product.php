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

Route::get('/them-san-pham', 'ProductController@add_product')->name('backend.add_product');
Route::post('/luu-san-pham', 'ProductController@save_product')->name('backend.save_product');
Route::get('/sua-san-pham/{product_id}', 'ProductController@edit_product')->name('backend.edit_product');
Route::get('/toan-bo-san-pham', 'ProductController@all_product')->name('backend.all_product');
Route::get('/xoa-san-pham-da-chon', 'ProductController@delete_product_selected')->name('backend.delete_product_selected');
Route::get('/xoa-san-pham', 'FetchDataController@delete_product')->name('backend.delete_product');
Route::get('/toan-bo-san-pham-json', 'ProductController@all_product_data_table')->name('backend.all_product_data_table');
Route::get('/xem-tam-thoi-san-pham', 'FetchDataController@view_product')->name('backend.temporary_view_product');

Route::post('/nhan-thong-bao-loi-san-pham', 'ExcelController@get_notify_product')->name('backend.get_notify_product');