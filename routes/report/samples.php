<?php

Route::get('/api/reportSample', "Report\SampleController@getList");
Route::get('api/reportSampleGeneral', 'Report\SampleController@getSampleGeneral');
Route::get('/api/reportClientTarget', "Report\SampleController@getListTarger");
Route::get('/api/reportSampleProduct', "Report\SampleController@getListProduct");
Route::get('/api/reportClientProductUnits', "HomeController@getListProductUnits");
Route::get('/api/reportSampleCities', "Report\ClientController@listCities");
Route::get('/api/reportProductByCategorySample', "Report\SampleController@getProductByCategory");
