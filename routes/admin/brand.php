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

//Thương hiệu sản phẩm
Route::get('/them-thuong-hieu-san-pham', 'BrandProduct@add_brand_product')->name('backend.add_brand');
Route::post('/luu-thuong-hieu-san-pham', 'BrandProduct@save_brand_product')->name('backend.save_brand');
Route::get('/sua-thuong-hieu-san-pham/{brand_pro_id}', 'BrandProduct@edit_brand_product')->name('backend.edit_brand');
Route::get('/xoa-thuong-hieu-san-pham/{brand_pro_id}', 'BrandProduct@delete_brand_product')->name('backend.delete_brand');
Route::get('/toan-bo-thuong-hieu-san-pham', 'BrandProduct@all_brand_product')->name('backend.all_brand');
Route::get('/toan-bo-thuong-hieu-san-pham-json', 'BrandProduct@all_brand_pro_json')->name('backend.all_brand_json');