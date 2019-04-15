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



Route::get('weather/{id}', 'Api\WeatherController@get_weather')->where('id', '[0-9]+');

Route::group(['namespace' => 'Api', 'as' => 'api.'], function () {
    Route::resource('orders', 'OrdersController', ['except' => ['create', 'edit']]);
    Route::resource('partners', 'PartnersController', ['except' => ['create', 'edit']]);
});
