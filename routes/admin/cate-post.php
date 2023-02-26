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

//Danh mục bài viết
Route::get('/toan-bo-danh-muc-bai-viet', 'CatePostController@list_cate_post')->name('backend.list_cate_post');
Route::post('/toan-bo-danh-muc-bai-viet-json', 'CatePostController@list_cate_post_json')->name('backend.list_cate_post_json');
Route::get('/an-hien-thi-danh-muc-bai-viet', 'FetchDataController@Cate_Post_Status')->name('backend.cate_post_status');
Route::get('/sua-danh-muc-bai-viet/{cate_post_id}', 'CatePostController@edit_cate_post')->name('backend.edit_cate_post');
Route::post('/luu-danh-muc-bai-viet', 'CatePostController@save_cate_post')->name('backend.save_cate_post');
Route::get('/xoa-danh-muc-bai-viet/{cate_post_id}', 'CatePostController@delete_cate_post')->name('backend.delete_cate_post');
Route::get('/xoa-danh-muc-bai-viet-da-chon', 'CatePostController@delete_cate_post_selected')->name('backend.delete_cate_post_selected');
