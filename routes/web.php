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

//Route::get('/shop/{vue_capture?}', function () { return view('vue.index'); })->where('vue_capture', '[\/\w\.-]*');

Auth::routes(['verify' => true]);


Route::apiResource('/cart','Ecommerce\ShoppingCartController', ['except' => 'show']);
Route::get('/count-cart', 'Ecommerce\ShoppingCartController@count')->name('cart.count');
Route::get('/p/{url}', 'Ecommerce\ShopController@product')->name('product.show.ecommerce');

Route::get('/shop','Ecommerce\ShopController@shop')->name('shop');
Route::get('/shopJson','Ecommerce\ShopController@shopJson')->name('shop.json');

Route::get('/about','Ecommerce\ShopController@about')->name('about');
Route::get('/contact','Ecommerce\ShopController@contact')->name('contact');
Route::post('/contact', 'Ecommerce\ShopController@sendContact');
Route::get('/terms_and_conditions','Ecommerce\ShopController@terms');

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


Route::prefix('admin')->group(function ()
{
    Route::get('/login', 'Auth\UserLoginController@showLoginForm')->name('user.login');
    Route::post('/login', 'Auth\UserLoginController@login')->name('user.login.submit');
    Route::get('/','Dashboard\DashboardController@index')->name('user.dashboard');
    Route::post('/logout', 'Auth\UserLoginController@logout')->name('user.logout');

    // Password reset routes
    Route::post('/password/email','Auth\UserForgotPasswordController@sendResetLinkEmail')->name('user.password.email');
    Route::get('/password/reset','Auth\UserForgotPasswordController@showLinkRequestForm')->name('user.password.request');
    Route::post('/password/reset','Auth\UserResetPasswordController@reset');
    Route::get('/password/reset/{token}','Auth\UserResetPasswordController@showResetForm')->name('user.password.reset');

    Route::group(['middleware' => 'auth:user'], function ()
    {
        Route::resource('/products','Dashboard\ProductController', ['except' => 'show']);
        Route::apiResource('/categories','Dashboard\CategoryController');
        Route::get('/profile','Dashboard\UserController@editProfile');
		Route::put('/profile/updated/{admin}','Dashboard\UserController@updateProfile');
        Route::put('/changePassword','Dashboard\UserController@changePassword');
        Route::apiResource('/customers','Dashboard\CustomerController');
        Route::apiResource('/orders','Dashboard\OrderController');
        Route::apiResource('/users','Dashboard\UserController');
    });
});
