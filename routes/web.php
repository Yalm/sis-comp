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

Auth::routes(['verify' => true]);


Route::apiResource('/cart','Ecommerce\ShoppingCartController', ['except' => 'show']);
Route::get('/count-cart', 'Ecommerce\ShoppingCartController@count')->name('cart.count');
Route::get('/p/{url}', 'Ecommerce\ShopController@product')->name('product.show.ecommerce');

Route::get('/shop','Ecommerce\ShopController@shop')->name('shop');;

Route::group(['middleware'=>['auth:web','verified']], function()
{
    Route::get('/account/complete-profile','Ecommerce\CustomerController@completeProfile');
    Route::put('/account/complete-profile','Ecommerce\CustomerController@completeProfilePayment');

	Route::prefix('profile')->group(function ()
	{
		Route::get('/','Ecommerce\CustomerController@home');
        Route::get('/orders','Ecommerce\OrderController@index');
        Route::get('/account','Ecommerce\CustomerController@account');
        Route::post('/changePassword','Ecommerce\CustomerController@changePassword')->name('changePassword');
        Route::put('/changeDataCustomer','Ecommerce\CustomerController@changeDataCustomer')->name('changeDataCustomer');
		Route::get('/orders/{order}','Ecommerce\OrderController@show');
	});

	Route::group(['middleware'=>'cart'], function()
	{
		Route::get('checkout','Ecommerce\PaymentController@checkout');
		Route::post('checkout','Ecommerce\PaymentController@success');
	});

	Route::put('customer/edit_profile','Shop\CustomerController@edit_profile');
});
