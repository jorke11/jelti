<?php

Route::get('/resize', 'ToolController@index');
Route::get('/fixed', 'ToolController@fixedInvoice');
Route::get('/photo', 'ToolController@readImagesProducts');
Route::get('/imagebanner', 'ToolController@readImagesBanner');
Route::get('/imagecategory', 'ToolController@readImagesCategory');

Route::get('/inventory/{warehouse_id}/{reference}', "ToolController@getProduct");
Route::get('/inventory/{warehouse_id}/{reference}/{quantity}/{lot}', "ToolController@addInventory");
Route::get('/inventory/{warehouse_id}/{reference}/{quantity}', "ToolController@addInventory");
