<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | This file is where you may define all of the routes that are handled
  | by your application. Just tell Laravel the URIs it should respond
  | to using a Closure or controller method. Build something great!
  |
 */

use App\Models;
use Models\Administration\Categories;


Route::get('/reportClient', "Report\ClientController@index");
Route::get('/reportSamples', "Report\SampleController@index");
Route::get('/reportOperations', "Report\OperationsController@index");

Route::get('/api/reportClient', "Report\ClientController@getList");
Route::get('/api/reportClientTarget', "Report\ClientController@getListTarger");
Route::get('/api/reportClientProduct', "HomeController@getListProduct");
Route::get('/api/reportClientProductDash', "HomeController@getListProductDash");
Route::get('/api/reportClientProductUnits', "HomeController@getListProductUnits");
Route::get('/api/reportSupplierDash', "HomeController@getListSupplier");
Route::get('/api/reportClientCities', "Report\ClientController@listCities");
Route::get('api/reportProductByClient', "Report\CommercialController@getProductByClient");

Route::get('/api/reportSample', "Report\SampleController@getList");
Route::get('/api/reportClientTarget', "Report\SampleController@getListTarger");
Route::get('/api/reportSampleProduct', "Report\SampleController@getListProduct");
Route::get('/api/reportClientProductUnits', "HomeController@getListProductUnits");
Route::get('/api/reportSampleCities', "Report\ClientController@listCities");
Route::get('/api/reportProductByCategorySample', "Report\SampleController@getProductByCategory");

Route::get('/api/reportResponse', "Report\OperationsController@getResponse");
Route::get('/operations/getAverageTime', "Report\OperationsController@getAverageTime");
Route::get('/operations/getShippingCostClient', "Report\OperationsController@getShippingCostClient");
Route::get('/operations/getMaxMin', "Report\OperationsController@getMinMax");
Route::get('operations/getNivelService', "Report\OperationsController@getNivelService");
Route::get('operations/getNoShipped', "Report\OperationsController@getNoShipped");

Route::get('/api/reportCommercial', "Report\CommercialController@listCommercial");
Route::get('/api/reportCommercialGraph', "Report\CommercialController@listCommercialGraph");

Route::get('/api/reportProductByCommercial', "Report\CommercialController@getProductByCommercial");
Route::get('/api/reportProductByCategory', "Report\ClientController@getProductByCategory");

Route::get('/reportSupplier', "Report\SupplierController@index");

Route::get('/api/reportSupplier', "Report\SupplierController@getList");
Route::get('/api/reportSupplierSales', "Report\SupplierController@getListSales");
Route::get('/api/reportSupplierClient', "Report\SupplierController@getListClient");
Route::get('/api/reportSales', "HomeController@getSales");

Route::get('/reportProduct', "Report\ProductController@index");
Route::get('/api/reportProductCity', "Report\ProductController@productByCity");

Route::get('/api/reportProduct', "Report\ProductController@getList");

Route::get('/reportCommercial', "Report\CommercialController@index");


Route::get('overview', "Report\ClientController@overview");
Route::get('overview/getOverview', "Report\ClientController@getOverview");

Route::get('CEO/getSalesUnits', "Report\ClientController@getSalesUnits");
Route::get('CEO/getSalesUnitsWare', "Report\ClientController@getSalesUnitsWare");

Route::get('operations/getProductWeek', "Report\OperationsController@ProductWeek");
Route::get('operations/getProductDay', "Report\OperationsController@ProductDay");

Route::get('comparative', "Report\ComparativeController@index");
Route::get('comparatives/salesClient', "Report\ComparativeController@salesClient");

