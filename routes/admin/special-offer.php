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

//Chiến dịch khuyến mãi
Route::get('them-chien-dich-khuyen-mai', 'SpecialOfferController@add_special')->name('backend.add_special');
Route::post('tim-kiem-san-pham-them-vao-khuyen-mai', 'SpecialOfferController@search_product')->name('backend.search_product_special');
Route::post('liet-ke-san-pham-da-chon', 'SpecialOfferController@special_list_checked')->name('backend.special_list_checked');
Route::post('toan-bo-san-pham-khuyen-mai-da-chon', 'SpecialOfferController@all_special_list_checked')->name('backend.all_special_list_checked');
Route::post('sap-xep-san-pham-khuyen-mai', 'SpecialOfferController@sort_by')->name('backend.sort_by_special');
Route::post('toan-bo-san-pham-theo-khuyen-mai', 'SpecialOfferController@all_product_special')->name('backend.all_product_special');
// Route::post('loai-tru-ma-khuyen-mai', 'SpecialOfferController@show_after_exclusion')->name('backend.show_after_exclusion');
Route::post('luu-chien-dich-khuyen-mai', 'SpecialOfferController@save_special')->name('backend.save_special');
Route::get('toan-bo-chien-dich-khuyen-mai', 'SpecialOfferController@all_special')->name('backend.all_special');
Route::get('/an-hien-thi-chien-dich-khuyen-mai', 'FetchDataController@special_status')->name('backend.special_status');
Route::post('/xoa-san-pham-chien-dich-khuyen-mai', 'SpecialOfferController@delete_special_product')->name('backend.delete_special_product');
Route::post('/xoa-chien-dich-khuyen-mai', 'SpecialOfferController@delete_special')->name('backend.delete_special');
Route::post('/thay-doi-gia-san-pham-chien dich-khuyen-mai', 'SpecialOfferController@special_product_change_price')->name('backend.special_product_change_price');

Route::get('chinh-sua-chien-dich-khuyen-mai/{special_id}', 'SpecialOfferController@edit_special')->name('backend.edit_special');
Route::post('cap-nhat-chien-dich-khuyen-mai/{special_id}', 'SpecialOfferController@update_special')->name('backend.update_special');