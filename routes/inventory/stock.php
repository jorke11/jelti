<?php

Route::get('/stock', 'Inventory\StockController@index');
Route::delete('/stock/{id}', 'Inventory\StockController@destroy');
Route::get('/api/listStock', 'Inventory\StockController@getStock');
