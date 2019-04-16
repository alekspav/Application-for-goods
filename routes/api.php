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


Route::group(['namespace' => 'Api', 'as' => 'api.'], function () {
    Route::get('weather/{id}', 'WeatherController@get_weather')->where('id', '[0-9]+');
    Route::resource('orders', 'OrdersController', ['except' => ['create', 'edit']]);
    Route::resource('partners', 'PartnersController', ['except' => ['create', 'edit']]);
    Route::resource('products', 'ProductsController', ['except' => ['create', 'edit']]);
    Route::resource('vendors', 'VendorsController', ['except' => ['create', 'edit']]);
    Route::resource('order_products', 'OrderProductsController', ['except' => ['create', 'edit', 'index']]);
    Route::get('get_products_by_order/{orderId}', 'OrderProductsController@getOrderProduct')->where('orderId', '[0-9]+');

});
