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

//Slide
Route::get('/toan-bo-slide', 'SlideController@list_slide')->name('backend.list_slide');
Route::post('/toan-bo-slide-json', 'SlideController@list_slide_json')->name('backend.list_slide_json');
Route::get('/an-hien-thi-slide', 'FetchDataController@slide_status')->name('backend.slide_status');
Route::get('/sua-slide/{slide_id}', 'SlideController@edit_slide')->name('backend.edit_slide');
Route::post('/luu-slide', 'SlideController@save_slide')->name('backend.save_slide');
Route::get('/xoa-slide/{slide_id}', 'SlideController@delete_slide')->name('backend.delete_slide');
Route::get('/xoa-slide-da-chon', 'SlideController@delete_slide_selected')->name('backend.delete_slide_selected');