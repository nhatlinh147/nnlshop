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

//Quản lý thuộc tính sản phẩm
Route::get('/quan-ly-thuoc-tinh-san-pham', 'PropProductController@all_prop_product')->name('backend.all_prop_product');
Route::post('/san-pham-da-chon-thuoc-tinh', 'PropProductController@products_selected_prop')->name('backend.products_selected_prop');
Route::post('/luu-thuoc-tinh', 'PropProductController@save_prop')->name('backend.save_prop');
Route::post('/danh-sach-thuoc-tinh', 'PropProductController@list_prop')->name('backend.list_prop');
Route::post('/sua-thuoc-tinh', 'PropProductController@edit_prop')->name('backend.edit_prop');
Route::post('/cap-nhat-thuoc-tinh', 'PropProductController@update_prop')->name('backend.update_prop');
Route::post('/xoa-thuoc-tinh', 'PropProductController@delete_prop')->name('backend.delete_prop');

Route::view('test', 'backend.component.component');
Route::view('test-script', 'backend.component.component-script');