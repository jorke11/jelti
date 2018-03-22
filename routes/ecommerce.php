<?php

Route::get('/ecommerce', 'Ecommerce\ShoppingController@index');
Route::get('/ecommerce/{id}', 'Ecommerce\ShoppingController@getDetailProduct');
Route::get('ecommerce/all/{id}/{subcategory_id}', 'Ecommerce\ShoppingController@getDetailProductAllCategory');
Route::get('/ecommerce/{categrory_id}/{subcategrory_id}', 'Ecommerce\ShoppingController@getDetailProductFilter');

Route::get('/getCategories', 'Ecommerce\ShoppingController@getCategories');
Route::get('/productDetail/{id}', 'Ecommerce\ShoppingController@getProduct');
Route::post('/addComment', 'Ecommerce\ShoppingController@addComment');
Route::get('/getComment/{id}', 'Ecommerce\ShoppingController@getComment');

Route::get('/getCounter', 'Ecommerce\ShoppingController@getCountOrders');

Route::get('/comments', 'MainController@getcomments');
Route::get('/comments/list/{id}', 'MainController@listComments');

Route::get('/payment', 'Ecommerce\PaymentController@index');
Route::get('/payment/{order_id}', 'Ecommerce\PaymentController@methodsPayment');
Route::get('/getDetail', 'Ecommerce\PaymentController@getDetail');
Route::put('/getDetailQuantity/{order_id}', 'Ecommerce\PaymentController@setQuantity');

Route::post('payment/target', 'Ecommerce\PaymentController@payment');
Route::post('payment/credit', 'Ecommerce\PaymentController@paymentCredit');
Route::post('payu', 'Ecommerce\PaymentController@payu');

Route::get('payment/responsepay', 'Ecommerce\PaymentController@responsePay');
Route::get('generatekey', "Ecommerce\PaymentController@generatekey");
Route::post('payment/confirmationpay', 'Ecommerce\PaymentController@confirmationPay');
Route::get('paymentest', "Payments\PaymentsController@index");

Route::delete('/deleteDetail/{id}', 'Ecommerce\PaymentController@deleteItem');
Route::post('/addDetail', 'Ecommerce\ShoppingController@managementOrder');

Route::get('myProfile', "Ecommerce\ShoppingController@getMyProfile");
Route::get('myOrders', "Ecommerce\ShoppingController@getMyOrders");
Route::get('payment/getCity/{department_id}', "Ecommerce\ShoppingController@getCities");



Route::get('api/listOrderClient', function() {
    $user = \App\Models\Security\Users::where("id", Auth::user()->id)->first();
    $query = DB::table('vdepartures')->where("client_id", $user->stakeholder_id);
    return Datatables::queryBuilder($query)->make(true);
});
