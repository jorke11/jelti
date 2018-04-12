<?php

Route::resource('/sample', 'Inventory\SampleController');
Route::get('/sample/{id}/consecutive', ['uses' => 'Inventory\SampleController@getConsecutive']);
Route::get('/sample/{id}/quantity', ['uses' => 'Inventory\SampleController@getQuantity']);
Route::get('/sample/{id}/getDetailProduct', ['uses' => 'Inventory\StockController@getDetailSample']);
Route::get('/sample/{id}/detail', ['uses' => 'Inventory\SampleController@getDetail']);
Route::get('/sample/{id}/editExt', ['uses' => 'Inventory\SampleController@getOrderExt']);
Route::post('/sample/storeDetail', 'Inventory\SampleController@storeDetail');
Route::put('/sample/detail/{id}', 'Inventory\SampleController@updateDetail');
Route::delete('/sample/detail/{id}', 'Inventory\SampleController@destroyDetail');
Route::get('/sample/getOrder/{id}', 'Inventory\SampleController@showOrder');
Route::post('/sample/storeExt', 'Inventory\SampleController@storeExtern');
Route::post('/sample/setSale/', 'Inventory\SampleController@setSale');
Route::get('/sample/{id}/getInvoice', ['uses' => 'Inventory\SampleController@getInvoice']);
Route::get('/sample/{id}/getRemission', ['uses' => 'Inventory\SampleController@getRemission']);
Route::get('/sample/{id}/getInvoiceHtml', ['uses' => 'Inventory\SampleController@getInvoiceHtml']);
Route::get('/sample/{id}/detailAll/', 'Inventory\SampleController@getAllDetail');
Route::put('/sample/generateInvoice/{id}', 'Inventory\SampleController@generateInvoice');
Route::put('/sample/generateRemission/{id}', 'Inventory\SampleController@generateRemission');

Route::get('/sample/{id}/getClient', ['uses' => 'Inventory\SampleController@getClient']);
Route::get('/sample/{id}/getBranch', ['uses' => 'Inventory\SampleController@getBranch']);
Route::post('/sample/uploadExcel', 'Inventory\SampleController@storeExcel');
Route::put('/sample/{id}/cancelInvoice', ['uses' => 'Inventory\SampleController@cancelInvoice']);

Route::get('/sample/{id}/{init}/{end}/', ['uses' => 'Inventory\SampleController@index']);
Route::get('/sample/{id}/{init}/{end}/{product}/{supplier}', ['uses' => 'Inventory\SampleController@index']);
Route::get('/sample/{id}/{init}/{end}/{user_id}', ['uses' => 'Inventory\SampleController@index']);
Route::get('/api/listSample', 'Inventory\SampleController@listTable');
Route::put('/sample/{id}/reverseInvoice', 'Inventory\SampleController@reverse');
Route::get('/sample/testDepNotification/{id}', 'Inventory\SampleController@testDepNotification');
Route::get('/sample/testInvoiceNotification/{id}', 'Inventory\SampleController@testInvoiceNotification');
