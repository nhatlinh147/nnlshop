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
//Bài viết
Route::get('/toan-bo-bai-viet', 'PostController@list_post')->name('backend.list_post');
Route::post('/toan-bo-bai-viet-json', 'PostController@list_post_json')->name('backend.list_post_json');
Route::get('/an-hien-thi-bai-viet', 'FetchDataController@post_status')->name('backend.post_status');
Route::get('/sua-bai-viet/{post_id}', 'PostController@edit_post')->name('backend.edit_post');
Route::post('/luu-bai-viet', 'PostController@save_post')->name('backend.save_post');
Route::get('/xoa-bai-viet/{post_id}', 'PostController@delete_post')->name('backend.delete_post');
Route::get('/xoa-bai-viet-da-chon', 'PostController@delete_post_selected')->name('backend.delete_post_selected');