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

Route::get('/', 'Ecommerce\ShopController@index')->name('home.shop');

Auth::routes();

Route::apiResource('/cart','Ecommerce\ShoppingCartController', ['except' => 'show']);
Route::get('/count-cart', 'Ecommerce\ShoppingCartController@count')->name('cart.count');
Route::get('/index-json', 'Ecommerce\ShoppingCartController@indexJson')->name('cart.json');
