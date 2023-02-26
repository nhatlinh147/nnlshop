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

//danh mục sản phẩm
Route::get('/them-danh-muc-san-pham', 'CategoryProduct@add_category_product')->name('backend.add_category');
Route::post('/luu-danh-muc-san-pham', 'CategoryProduct@save_category_product')->name('backend.save_category');
Route::get('/sua-danh-muc-san-pham/{cate_pro_id}', 'CategoryProduct@edit_category_product')->name('backend.edit_category');
Route::get('/xoa-danh-muc-san-pham/{cate_pro_id}', 'CategoryProduct@delete_category_product')->name('backend.delete_category');
Route::get('/toan-bo-danh-muc-san-pham', 'CategoryProduct@all_category_product')->name('backend.all_category');
Route::get('/toan-bo-danh-muc-san-pham-json', 'CategoryProduct@all_cate_pro_json')->name('backend.all_cate_pro_json');