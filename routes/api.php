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
Route::put('/user/changeinfo/{id}', 'UserController@changeUserInfo');
Route::put('/user/password/{id}', 'UserController@changeUserPassword');
Route::put('/saved/moveback/{uid}/{pid}', 'CartController@moveToBag');
Route::delete('/cart/{uid}/{pid}', 'CartController@deleteCart');
Route::post('/user/coupon', 'CartController@useCoupon');
Route::get('/admin/products', 'ProductsController@getAllProducts');
Route::get('/admin/products/page={num}', 'ProductsController@changeAdminPage');

