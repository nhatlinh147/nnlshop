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

//Đăng xuất tài khoản
Route::get('/dang-xuat', 'CustomerController@logout_by_auth')->name('frontend.logout_by_auth');

//Đăng xuất tài khoản
Route::post('/kiem-tra-ma-uu-dai', 'CouponController@check_coupon')->name('frontend.check_coupon');
Route::post('/ap-dung-ma-uu-dai', 'CouponController@apply_coupon')->name('frontend.apply_coupon');

//Sản phẩm yêu thích
Route::get('/them-san-pham-yeu-thich', 'FavoriteController@add_favorite')->name('frontend.add_favorite');
Route::get('/hien-thi-san-pham-yeu-thich', 'FavoriteController@show_favorite')->name('frontend.show_favorite');
Route::get('/huy-yeu-thich-san-pham', 'FavoriteController@cancel_favorite')->name('frontend.cancel_favorite');