<?php

Route::resource('/departure', 'Sales\DepartureController');
Route::get('/departure/{id}/consecutive', ['uses' => 'Sales\DepartureController@getConsecutive']);
Route::get('/departure/{id}/quantity', ['uses' => 'Sales\DepartureController@getQuantity']);
Route::get('/departure/{id}/getDetailProduct', ['uses' => 'Inventory\StockController@getDetailProduct']);
Route::get('/departure/{id}/detail', ['uses' => 'Sales\DepartureController@getDetail']);
Route::get('/departure/{id}/editExt', ['uses' => 'Sales\DepartureController@getOrderExt']);
Route::post('/departure/storeDetail', 'Sales\DepartureController@storeDetail');
Route::put('/departure/detail/{id}', 'Sales\DepartureController@updateDetail');
Route::delete('/departure/detail/{id}', 'Sales\DepartureController@destroyDetail');
Route::get('/departure/getOrder/{id}', 'Sales\DepartureController@showOrder');
Route::post('/departure/storeExt', 'Sales\DepartureController@storeExtern');
Route::post('/departure/setSale/', 'Sales\DepartureController@setSale');
Route::get('/departure/{id}/getInvoice', ['uses' => 'Sales\DepartureController@getInvoice']);
Route::get('/departure/{id}/getRemission', ['uses' => 'Sales\DepartureController@getRemission']);
Route::get('/departure/{id}/getInvoiceHtml', ['uses' => 'Sales\DepartureController@getInvoiceHtml']);
Route::get('/departure/{id}/detailAll/', 'Sales\DepartureController@getAllDetail');
Route::put('/departure/generateInvoice/{id}', 'Sales\DepartureController@generateInvoice');
Route::put('/departure/generateRemission/{id}', 'Sales\DepartureController@generateRemission');
Route::get('/departure/repair/{id}/{warehouse_id}', 'Sales\DepartureController@repair');

Route::get('/departure/{id}/getClient', ['uses' => 'Sales\DepartureController@getClient']);
Route::get('/departure/{id}/getBranch', ['uses' => 'Sales\DepartureController@getBranch']);
Route::post('/departure/uploadExcel', 'Sales\DepartureController@storeExcel');
Route::put('/departure/{id}/cancelInvoice', ['uses' => 'Sales\DepartureController@cancelInvoice']);

Route::get('/departure/{id}/{init}/{end}/', ['uses' => 'Sales\DepartureController@index']);
Route::get('/departure/{id}/{init}/{end}/{product}/{supplier}', ['uses' => 'Sales\DepartureController@index']);
Route::get('/departure/{id}/{init}/{end}/{user_id}', ['uses' => 'Sales\DepartureController@index']);
Route::get('/api/listDeparture', 'Sales\DepartureController@listTable');
Route::put('/departure/{id}/reverseInvoice', 'Sales\DepartureController@reverse');
Route::get('/departure/testDepNotification/{id}', 'Sales\DepartureController@testDepNotification');
Route::get('/departure/testInvoiceNotification/{id}', 'Sales\DepartureController@testInvoiceNotification');
Route::get('/departure/funat/{id}', 'Sales\DepartureController@caseFunat');
Route::post('/processDeparture', 'Sales\DepartureController@processDeparture');