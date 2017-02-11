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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/dash', 'DashboardController@index');

Route::resource('/product', 'Administration\ProductController');
Route::resource('/entry', 'EntryController');
Route::resource('/departure', 'DepartureController');
Route::resource('/category', 'Administration\CategoryController');
Route::resource('/supplier', 'Administration\SupplierController');
Route::resource('/warehouse', 'Administration\WarehouseController');
Route::resource('/entry', 'EntryController');
Route::get('/entry/{id}/consecutive', ['uses' => 'EntryController@getConsecutive']);

Route::get('/api/listCategory', function() {
    return Datatables::eloquent(Models\Administration\Category::query())->make(true);
});

Route::get('/api/listSupplier', function() {
    return Datatables::eloquent(Models\Administration\Supplier::query())->make(true);
});
Route::get('/api/listProduct', function() {
    return Datatables::eloquent(Models\Administration\Product::query())->make(true);
});
Route::get('/api/listWarehouse', function() {
    return Datatables::eloquent(Models\Administration\Warehouse::query())->make(true);
});
Route::get('/api/listEntries', function() {
    return Datatables::eloquent(Models\Inventory\Entry::query())->make(true);
});
