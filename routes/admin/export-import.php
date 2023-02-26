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

Route::get('/xuat-tep-excel-san-pham', 'ExcelController@export_excel')->name('backend.export_excel');
Route::get('/xuat-tep-pdf-san-pham', 'ExcelController@export_pdf')->name('backend.export_pdf');
Route::post('/nhap-tep-excel-san-pham', 'ExcelController@import_excel_product')->name('backend.import_excel_product');

Route::get('/category-status', 'FetchDataController@category_status')->name('backend.category_status');
Route::get('/brand-status', 'FetchDataController@brand_status')->name('backend.brand_status');
Route::get('/product-status', 'FetchDataController@product_status')->name('backend.product_status');

Route::get('/liet-ke-anh-san-pham/{product_slug}', 'GalleryController@list_gallery')->name('backend.list_gallery');