<?php

use Illuminate\Support\Facades\Route;

Auth::routes(['register' => false]);

Route::get('/', 'HomeController@landing')->name('landing');
Route::get('/verifyMobile', 'HomeController@verifyMobile');
Route::get('/verifyToken', 'HomeController@verifyToken');
Route::post('/verifyMobile', 'CustomerController@verifyMobile')->name('verifyMobile');
Route::post('/verifyToken', 'CustomerController@verifyToken')->name('verifyToken');

Route::middleware('customer.auth')->group(function () {
    Route::get('/orders', 'CustomerController@orders')->name('customer.orders');
    Route::get('/addresses', 'AddressController@addresses')->name('customer.addresses');
    Route::get('/selectAddress', 'AddressController@selectAddress')->name('customer.selectAddress');
    Route::get('/selectNeighbourhood/{address?}', 'AddressController@selectNeighbourhood')->name('customer.selectNeighbourhood');
    Route::get('/getNeighbourhoods/{city}/{keyword?}', 'AddressController@getNeighbourhoods');
    Route::get('/postNeighbourhood/{neighbourhood}/{address?}', 'AddressController@postNeighbourhood')->name('customer.postNeighbourhood');
    Route::post('/postAddressDetail', 'AddressController@postAddressDetail')->name('customers.postAddressDetail');
    Route::get('addresses/makeDefault/{addressId}','AddressController@makeDefaultAddress')->name('customers.makeDefaultAddress');
    Route::get('/removeAddress/{address}','AddressController@removeAddress')->name('customers.removeAddress');
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
