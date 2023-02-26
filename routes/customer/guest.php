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
Route::get('/', 'HomeController@index')->name('frontend.index');
Route::get('/trang-chu', 'HomeController@index')->name('frontend.index');
Route::get('/tim-kiem-san-pham', 'HomeController@search_product')->name('frontend.search_product');

Route::get('/hien-thi-san-pham', 'ShoppingController@show_product')->name('frontend.show_product');
Route::get('/loc-theo-gia', 'ShoppingController@filter_price')->name('frontend.filter_price');

Route::get('/chi-tiet-san-pham/{product_slug}', 'ShoppingController@show_detail_product')->name('frontend.show_detail_product');

//Thêm giỏ hàng
Route::get('/hien-thi-gio-hang', 'CartController@show_cart')->name('frontend.show_cart');
Route::get('/them-gio-hang', 'CartController@save_cart')->name('frontend.save_cart');
Route::get('/them-gio-hang-khong-can-dang-nhap', 'CartController@add_cart_guest')->name('frontend.add_cart_guest');
Route::get('/xoa-gio-hang/{cart_id}', 'CartController@delete_cart')->name('frontend.delete_cart');
Route::get('/xoa-gio-theo-lua-chon', 'CartController@delete_selected_cart')->name('frontend.delete_selected_cart');

//Thêm sản phẩm yêu thích
Route::get('/them-san-pham-yeu-thich', 'FavoriteController@add_favorite')->name('frontend.add_favorite');

//Kiểm tra tồn tại để hiển thị tin nhắn thông báo lỗi cho chức năng form đăng ký
Route::get('/kiem-tra-ton-tai', 'CustomerController@check_exist')->name('frontend.check_exist');