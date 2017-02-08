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

Route::resource('/products', 'ProductController');
Route::resource('/entry', 'EntryController');
Route::resource('/departure', 'DepartureController');
Route::resource('/category', 'CategoryController');
Route::resource('/supplier', 'SupplierController');

Route::get('/api/listCategory', function() {
    return Datatables::eloquent(Models\Core\Category::query())->make(true);
});

Route::get('/api/listSupplier', function() {
    return Datatables::eloquent(Models\Administration\Suppliers::query())->make(true);
});
Route::get('/api/listProducts', function() {
    return Datatables::eloquent(Models\Administration\Suppliers::query())->make(true);
});
