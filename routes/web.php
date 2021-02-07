<?php

use Illuminate\Support\Facades\Route;

Auth::routes(['register' => false]);

Route::get('/', 'HomeController@landing')->name('landing');
Route::get('/verifyMobile', 'HomeController@verifyMobile');
Route::get('/verifyToken', 'HomeController@verifyToken');
Route::post('/verifyMobile', 'CustomerController@verifyMobile')->name('verifyMobile');
Route::post('/verifyToken', 'CustomerController@verifyToken')->name('verifyToken');

Route::middleware('customer.auth')->group(function () {

    Route::prefix('orders')->group(function () {
        Route::get('/', 'CustomerController@orders')->name('customers.orders');
    });

    Route::prefix('addresses')->group(function () {
        Route::get('/', 'AddressController@addresses')->name('customers.addresses');
        Route::get('/selectNeighbourhood/{redirect}/{address?}', 'AddressController@selectNeighbourhood')->name('customers.selectNeighbourhood');
        Route::get('/getNeighbourhoods/{city}/{keyword?}', 'AddressController@getNeighbourhoods')->name('customers.getNeighbourhoods');
        Route::get('/postNeighbourhood/{neighbourhood}/{address?}', 'AddressController@postNeighbourhood')->name('customers.postNeighbourhood');
        Route::post('/postAddressDetail', 'AddressController@postAddressDetail')->name('customers.postAddressDetail');
        Route::get('/makeDefault/{addressId}','AddressController@makeDefaultAddress')->name('customers.makeDefaultAddress');
        Route::get('/removeAddress/{address}','AddressController@removeAddress')->name('customers.removeAddress');
    });

    Route::prefix('order')->group(function () {
        Route::get('/orderProduct/{product}','CustomerController@getOrderProduct')->name('customers.orderProduct');
        Route::get('/orderFirstStep/{product}/{weight}','CustomerController@orderFirstStep')->name('customers.orderFirstStep');
        Route::get('/selectAddress', 'AddressController@selectAddress')->name('customers.selectAddress');
        Route::get('/getTime','CustomerController@getTime')->name('customers.getTime');
    });
});

Route::prefix('admin')->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('/', function () {
            return redirect('/admin/products');
        });

        Route::resource('products', 'ProductController');
        Route::resource('availableProducts', 'AvailableProductController');
        Route::post('availableProducts/storeDetails', 'AvailableProductController@storeDetails')->name('availableProducts.storeDetails');
        Route::get('availableProducts/{availableProduct}/toggleActivate', 'AvailableProductController@toggleActivate')->name('availableProducts.toggleActivate');

        Route::get('orders', 'OrderController@index', ['except' => ['index','show']]);
        Route::get('orders/{availableProduct?}', 'OrderController@index')->name('orders.index');
        Route::get('orders/{order}/delivered', 'OrderController@delivered')->name('orders.delivered');

        Route::resource('users', 'UserController');
        Route::get('users/{user}/resetPassword', 'UserController@resetPassword')->name('users.resetPassword');
        Route::get('users/{user}/profile', 'UserController@changePassword')->name('users.changePassword');
        Route::post('users/updatePassword', 'UserController@updatePassword')->name('users.updatePassword');
    });
});

Route::get('/home', 'HomeController@index')->name('home');
