<?php

use Illuminate\Support\Facades\Route;

Auth::routes(['register' => false]);

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    return "Cache is cleared";
});

Route::get('/', 'HomeController@landing');
Route::get('/landing/{reference?}', 'HomeController@landing')->name('landing');

Route::middleware('customer.notLoggedIn')->group(function () {
    Route::get('/verifyMobile', 'HomeController@verifyMobile')->name('customers.verifyMobile');
    Route::get('/verifyToken/{mobile?}', 'HomeController@verifyToken')->name('customers.verifyToken');
    Route::post('/verifyMobile', 'CustomerController@verifyMobile')->name('verifyMobile');
    Route::post('/verifyToken', 'CustomerController@verifyToken')->name('verifyToken');
});

Route::middleware('customer.auth')->group(function () {

    Route::prefix('orders')->group(function () {
        Route::get('/list', 'CustomerOrderController@index')->name('customers.orders');
        Route::get('/{order}/products', 'CustomerOrderController@orderProducts')->name('customers.orders.products');
        Route::get('/{order}/address', 'CustomerOrderController@orderAddress')->name('customers.orders.address');
        Route::get('/{order}/bill', 'CustomerOrderController@orderBill')->name('customers.orders.bill');
    });

    Route::prefix('addresses')->group(function () {
        Route::get('/list', 'AddressController@addresses')->name('customers.addresses');
        Route::get('/selectNeighbourhood/{redirect}/{address?}', 'AddressController@selectNeighbourhood')->name('customers.selectNeighbourhood');
        Route::get('/getNeighbourhoods/{city}/{keyword?}', 'AddressController@getNeighbourhoods')->name('customers.getNeighbourhoods');
        Route::get('/postNeighbourhood/{neighbourhood}/{address?}', 'AddressController@postNeighbourhood')->name('customers.postNeighbourhood');
        Route::post('/postAddressDetail', 'AddressController@postAddressDetail')->name('customers.postAddressDetail');
        Route::get('/makeDefault/{addressId}','AddressController@makeDefaultAddress')->name('customers.makeDefaultAddress');
        Route::get('/removeAddress/{address}','AddressController@removeAddress')->name('customers.removeAddress');
    });

    Route::prefix('order')->group(function () {
        Route::get('/orderProduct/{product}','CustomerController@getOrderProduct')->name('customers.orderProduct');
        Route::get('/orderFirstStep/{weight}','CustomerController@orderFirstStep')->name('customers.orderFirstStep');
        Route::get('/selectAddress', 'AddressController@selectAddress')->name('customers.selectAddress');
        Route::get('/getTime/{customerName}','CustomerController@getTime')->name('customers.getTime');
        Route::post('/payment', 'CustomerController@selectTime')->name('customers.selectTime');
        Route::post('/selectPaymentMethod', 'CustomerController@selectPaymentMethod')->name('customers.selectPaymentMethod');
        Route::get('/finializeOrder', 'CustomerController@finializeOrder')->name('customers.finializeOrder');
    });

    Route::get('/customer/logout', 'CustomerController@logout')->name('customers.logout');
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

        Route::get('/customers', 'CustomerController@index')->name("customers.index");
        Route::get('/neighbourhoods', 'AddressController@neighbourhoodsList')->name("neighbourhoods.index");

        Route::resource('users', 'UserController');
        Route::get('users/{user}/resetPassword', 'UserController@resetPassword')->name('users.resetPassword');
        Route::get('users/{user}/profile', 'UserController@changePassword')->name('users.changePassword');
        Route::post('users/updatePassword', 'UserController@updatePassword')->name('users.updatePassword');
    });
});

Route::get('/home', 'HomeController@index')->name('home');
