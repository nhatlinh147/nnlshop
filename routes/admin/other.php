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

//Phí giao hàng
Route::get('/quan-ly-phi-giao-hang', 'FeeShippingController@fee_shipping')->name('backend.fee_shipping');
Route::post('/thiet-lap-giao-hang', 'FeeShippingController@save_fee_shipping')->name('backend.save_fee_shipping');
Route::get('/cap-nhat-phi-giao-hang', 'FeeShippingController@update_fee_shipping')->name('backend.update_fee_shipping');

//Đăng xuất tài khoản
Route::get('/dang-xuat', 'LoginController@logout_by_auth')->name('backend.logout_by_auth');

//Ảnh cho từng sản phẩm
Route::post('/tai-lai-anh', 'GalleryController@load_gallery_ajax')->name('backend.load_gallery_ajax');
Route::post('/them-anh/{product_id}', 'GalleryController@insert_gallery')->name('backend.insert_gallery');
Route::post('/doi-ten-anh', 'GalleryController@update_gallery_name')->name('backend.update_gallery_name');
Route::post('/xoa-anh', 'GalleryController@delete_gallery')->name('backend.delete_gallery');
Route::post('/xoa-anh-da-chon', 'GalleryController@delete_gallery_selected')->name('backend.delete_gallery_selected');
Route::post('/cap-nhat-anh', 'GalleryController@update_gallery')->name('backend.update_gallery');


Route::get('/liet-ke-du-lieu-ggdrive', 'GGDriveController@read_data')->name('backend.read_data');


Route::get('/lay-path-ggdrive', 'ProductController@get_path')->name('backend.get_path_googleDrive');

//Test Sending Mail in Laravel Queue
Route::get('/gui-mail', 'MailController@send_mail')->name('backend.send_mail');


Route::get('/delete-document/{path}', 'GGDriveController@delete_document')->name('backend.delete_document');
Route::get('chuyen-ten-thanh-path', 'ProductController@trans_path_google_drive')->name('backend.trans_path');

Route::get('active-dropdown', 'FetchDataController@active_dropdown')->name('backend.active_dropdown');

//Phân tích dữ liệu
Route::get('/trang-chu-quan-ly-tai-chinh', 'AdminController@dashboard_finance')->name('backend.dashboard_finance'); // trang chủ
Route::post('thong-ke-7-ngay-gan-day', 'AdminController@order_statistics_ajax')->name('backend.order_statistics_ajax');
Route::get('quan-ly-doanh-so', 'AdminController@dashboard_sale')->name('backend.dashboard_sale');
Route::post('loc-ket-qua', 'AdminController@filter_by_date_ajax')->name('backend.filter_by_date_ajax');