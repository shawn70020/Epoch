<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/signin', 'UserController@store')->where('any', '.*');
Route::post('/login', 'UserController@checkLogin')->where('any', '.*');
Route::put('/user/logout', 'UserController@userLogout')->where('any', '.*');
Route::post('/products/imageupload', 'ProductsController@imageUpload')->where('any', '.*');
Route::post('/products/upload', 'ProductsController@createProducts')->where('any', '.*');
Route::put('/products/update', 'ProductsController@updateProducts')->where('any', '.*');
Route::get('/products/men', 'ProductsController@getMenProducts')->where('any', '.*');
Route::get('/products/women', 'ProductsController@getWomenProducts')->where('any', '.*');
Route::get('/products/men/item/{id}', 'ProductsController@getSingleProduct')->where('any', '.*');
Route::get('/getuserinfo/{token}', 'UserController@getUserInfo')->where('any', '.*');
Route::post('/user/addcart', 'CartController@addCart')->where('any', '.*');
Route::post('/user/getusercart', 'CartController@getUserCart')->where('any', '.*');
Route::post('/user/updatecart', 'CartController@updateUserCart')->where('any', '.*');
Route::post('/user/checkout', 'CartController@addOrder');
Route::get('/products/{sex}/page={num}', 'ProductsController@changePage');
Route::get('/user/info/{id}', 'UserController@getUserData');
Route::get('/user/saved/{id}', 'UserController@getUserSaved');
Route::post('/user/saved/item', 'cartController@saveItem');
Route::put('/user/changeinfo/{id}', 'UserController@changeUserInfo');
Route::put('/user/password/{id}', 'UserController@changeUserPassword');
Route::put('/saved/moveback/{uid}/{pid}', 'CartController@moveToBag');
Route::delete('/cart/{uid}/{pid}', 'CartController@deleteCart');
Route::post('/user/coupon', 'CartController@useCoupon');
Route::get('/admin/products', 'ProductsController@getAllProducts');
Route::get('/admin/products/page={num}', 'ProductsController@changeAdminPage');
Route::get('/admin/coupons/page={num}', 'OrderController@changeCouponPage');
Route::get('/admin/orders', 'OrderController@getTodayOrder');
Route::get('/admin/member/page={num}', 'UserController@changeUserPage');
Route::post('/coupons/upload', 'OrderController@createCoupons');
Route::put('/coupons/update', 'OrderController@updateCoupons');
Route::get('/orders/detail/{id}', 'OrderController@getOrderDetails');
Route::get('/member/detail/{id}', 'UserController@getMemberDetails');
Route::get('/orders/status/{oid}/{status}', 'OrderController@changeOrderStatus');
Route::get('/member/status/{uid}/{status}', 'UserController@changeUserStatus');
Route::post('/orders/{oid}/ship', 'OrderdetailsController@shipItem');
Route::get('/member/status/{uid}/{status}', 'UserController@changeUserStatus');
Route::get('/user/myorder/{uid}', 'UserController@getMyOrders');
Route::get('/myorder/detail/{oid}', 'UserController@getMyOrderdetail');
Route::get('/carousel/item', 'ProductsController@getCarouselItem');
Route::delete('/products/delete/{id}', 'ProductsController@deleteProduct');
Route::delete('/coupons/delete/{id}', 'ProductsController@deleteCoupon');
Route::post('/orders/datepick', 'OrderController@getDateOrder');
Route::get('/products/{id}', 'ProductsController@checkProduct');
Route::get('/orders/{oid}/{uid}', 'OrderController@checkOrder');
Route::get('/user/status/{token}', 'UserController@checkStatus');
Route::get('/admin/order/{oid}', 'OrderController@checkAllOrder');
Route::get('/admin/member/{uid}', 'UserController@checkAllMember');
