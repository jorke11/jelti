<?php

Route::get('/shopping', 'Shopping\ShoppingController@index');
Route::get('/shopping/{id}', 'Shopping\ShoppingController@getDetailProduct');

Route::get('/getCategories', 'Shopping\ShoppingController@getCategories');
Route::get('/productDetail/{id}', 'Shopping\ShoppingController@getProduct');
Route::post('/addComment', 'Shopping\ShoppingController@addComment');
Route::get('/getComment/{id}', 'Shopping\ShoppingController@getComment');


Route::get('/comments', 'MainController@getcomments');
Route::get('/comments', 'MainController@getcomments');
Route::get('/comments/list/{id}', 'MainController@listComments');

Route::get('/payment', 'Shopping\PaymentController@index');
Route::get('/getDetail', 'Shopping\PaymentController@getDetail');
Route::put('/getDetailQuantity/{order_id}', 'Shopping\PaymentController@setQuantity');

Route::post('payment/target', 'Shopping\PaymentController@payment');