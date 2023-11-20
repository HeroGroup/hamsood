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
Route::get('/landing', 'HomeController@landing')->name('landing');
Route::get('/category/{category}', 'HomeController@categoryLanding')->name('categoryLanding');
Route::get('/product/{product}', 'HomeController@productDetailPage')->name('productDetailPage');
Route::get('/suggestion/{uid}', 'HomeController@suggest')->name('suggest');
Route::get('/terms', function() { return view('terms'); });
Route::get('/supportingAreas', 'HomeController@supportingAreas')->name('supportingAreas');
Route::get('/payment/payir/callback', 'PaymentController@verifyPayir');
Route::get('/payment/Zarinpal/callback', 'PaymentController@verifyZarinpal');

Route::middleware('customer.notLoggedIn')->group(function () {
    Route::get('/signup', function() { return redirect(\route('customers.login')); });

    Route::get('/customer/login', 'CustomerAuthController@login')->name('customers.login');
    Route::get('/customer/signup/{mobile}', 'CustomerAuthController@signup')->name('customers.signup'); // same as login
    Route::get('/customer/token/{mobile}', 'CustomerAuthController@token')->name('customers.token');

    Route::post('/verifyMobile', 'CustomerAuthController@verifyMobile')->name('verifyMobile');
    Route::post('/verifyInvitor', 'CustomerAuthController@verifyInvitor')->name('verifyInvitor');
    Route::post('/verifyToken', 'CustomerAuthController@verifyToken')->name('verifyToken');

});

Route::middleware('customer.auth')->group(function () {

    Route::prefix('orders')->group(function () {
        Route::get('/list', 'CustomerOrderController@index')->name('customers.orders');
        Route::get('/current', 'CustomerOrderController@currentOrders')->name('customers.orders.current');
        Route::get('/success', 'CustomerOrderController@successOrders')->name('customers.orders.success');
        Route::get('/failed', 'CustomerOrderController@failedOrders')->name('customers.orders.failed');
        Route::get('/{order}/products', 'CustomerOrderController@orderProducts')->name('customers.orders.products');
        Route::get('/{order}/address', 'CustomerOrderController@orderAddress')->name('customers.orders.address');
        Route::get('/{order}/bill', 'CustomerOrderController@orderBill')->name('customers.orders.bill');
        Route::get('/{order}/cancel', 'CustomerOrderController@cancelOrder')->name('customers.orders.cancelOrder');
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
        Route::get('/addToCart/{product}/{return?}','CustomerCartController@addToCart')->name('customers.addToCart');
        Route::get('/increaseCartItem/{product}','CustomerCartController@increaseCartItem')->name('customers.increaseCartItem');
        Route::get('/decreaseCartItem/{product}','CustomerCartController@decreaseCartItem')->name('customers.decreaseCartItem');
        Route::get('/customerCart','CustomerCartController@getCustomerCart')->name('customers.customerCart');
        Route::get('/selectAddress', 'AddressController@selectAddress')->name('customers.selectAddress');
        Route::get('/getTime/{customerName}','CustomerController@getTime')->name('customers.getTime');
        Route::post('/payment', 'CustomerController@selectTime')->name('customers.selectTime');
        Route::post('/confirmBill', 'CustomerController@confirmBill')->name('customers.confirmBill');
        Route::post('/finalizeOrder', 'CustomerController@finalizeOrder')->name('customers.finalizeOrder');
        Route::get('/paid','CustomerController@paid')->name('customers.paid');
    });

    Route::prefix('payment')->group(function () {
        Route::get('/wallet','PaymentController@wallet')->name('customers.wallet');
        Route::get('/transactions','PaymentController@transactions')->name('customers.transactions');
        Route::post('/pay','PaymentController@pay')->name('customers.pay');
        Route::get('/notPaid/{back?}','PaymentController@notPaid')->name('customers.notPaid');
    });

    Route::prefix('notifications')->group(function () {
        Route::get('/','NotificationController@index')->name('customers.notifications');
    });

    Route::get('/userCartItemsCount/{ajax?}', 'HomeController@userCartItemsCount')->name('customers.userCartItemsCount');
    Route::get('/customer/profile', 'CustomerController@profile')->name('customers.profile');
    Route::post('/customer/updateProfile', 'CustomerController@updateProfile')->name('customers.updateProfile');

    Route::get('/support', 'HomeController@support')->name('support');
    Route::post('/support', 'HomeController@postMessage')->name('postMessage');

    Route::get('/about', 'HomeController@about')->name('about');

    Route::get('/customer/logout', 'CustomerAuthController@logout')->name('customers.logout');
});

Route::prefix('admin')->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('/', function () {
            return redirect('/admin/products');
        });

        Route::get('/settings', 'SettingController@getSettings')->name('settings');
        Route::post('/settings', 'SettingController@postSettings')->name('settings.post');

        Route::get('/supportingAreas', 'SettingController@supportingAreas')->name('settings.supportingAreas');
        Route::post('/supportingAreas', 'SettingController@storeSupportingArea')->name('settings.supportingAreas.store');
        Route::put('/supportingAreas/{area}', 'SettingController@updateSupportingArea')->name('settings.supportingAreas.update');
        Route::delete('/supportingAreas/{area}', 'SettingController@removeSupportingArea')->name('settings.supportingAreas.remove');

        Route::resource('products', 'ProductController');
        Route::resource('availableProducts', 'AvailableProductController');
        Route::post('availableProducts/storeDetails', 'AvailableProductController@storeDetails')->name('availableProducts.storeDetails');
        Route::get('availableProducts/{availableProduct}/toggleActivate', 'AvailableProductController@toggleActivate')->name('availableProducts.toggleActivate');

        Route::get('orders/index/{availableProduct?}/{customer?}', 'OrderController@index')->name('orders.index');
        Route::get('orders/delivered/{order}', 'OrderController@delivered')->name('orders.delivered');
        Route::get('orders/failed/{order}', 'OrderController@failed')->name('orders.failed');
        Route::get('orders/bill/{order}', 'OrderController@bill')->name('orders.bill');

        Route::post('categories', 'CategoryController@store')->name('categories.store');

        Route::get('orders/payback', 'OrderController@payback');
        Route::get('orders/paybackSMS', 'OrderController@paybackSMS');

        Route::get('/customers', 'CustomerController@index')->name("customers.index");
        Route::get('/customers/{customer}/addresses', 'CustomerController@customerAddresses')->name("admin.customers.addresses");
        Route::get('/customers/{customer}/transactions', 'CustomerController@customerTransactions')->name("admin.customers.transactions");
        Route::get('/neighbourhoods', 'AddressController@neighbourhoodsList')->name("neighbourhoods.index");
        Route::get('/toggleActivateNeighbourhood/{id}', 'AddressController@toggleActivateNeighbourhood')->name("neighbourhoods.toggleActivateNeighbourhood");
        Route::get('/customer/login/{mobile}','CustomerController@loginWithCustomer')->name('admin.customers.login');

        Route::get('/carts', 'CartController@index')->name('carts.index');
        Route::get('/carts/destroy/{customerId}', 'CartController@destroy')->name('carts.destroy');

        Route::resource('/deliveries', 'DeliveryController')->except(['show', 'edit']);

        Route::resource('/neighbourhoodDeliveries', 'NeighbourhoodDeliveryController')->except(['index', 'create', 'show', 'edit']);
        Route::get('/neighbourhoodDeliveries/{neighbourhood}', 'NeighbourhoodDeliveryController@index')->name('neighbourhoodDeliveries.index');
        Route::get('/neighbourhoodDeliveries/create/{neighbourhood}', 'NeighbourhoodDeliveryController@create')->name('neighbourhoodDeliveries.create');

        Route::get('/support', 'SettingController@support')->name('admin.support');

        Route::resource('users', 'UserController');
        Route::get('users/{user}/resetPassword', 'UserController@resetPassword')->name('users.resetPassword');
        Route::get('users/{user}/profile', 'UserController@changePassword')->name('users.changePassword');
        Route::post('users/updatePassword', 'UserController@updatePassword')->name('users.updatePassword');
    });
});

Route::get('/home', 'HomeController@index')->name('home');
