<?php

Route::get('/stock', 'Inventory\StockController@index');
Route::get('/stock/{id}/detailInventory', 'Inventory\StockController@detailInventory');
Route::delete('/stock/{id}', 'Inventory\StockController@destroy');
Route::get('/api/listStock', 'Inventory\StockController@getStock');
Route::get('/api/listStockTransit', 'Inventory\StockController@getStockTransit');


Route::get('/inventory/{warehouse_id}/{reference}', "ToolController@getProduct");
Route::get('/inventory/{warehouse_id}/{reference}/{quantity}/{lot}/{vencimiento}', "ToolController@addInventory");
Route::get('/uinventory', "ToolController@formInventory");
Route::get('/ulug', "ToolController@updateSlug");
Route::post('/setinventory', "ToolController@storeInventory");
