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
Route::get('/kardex', 'Inventory\KardexController@index');

Route::resource('/product', 'Administration\ProductController');

Route::resource('/category', 'Administration\CategoryController');
Route::resource('/supplier', 'Administration\SupplierController');
Route::resource('/warehouse', 'Administration\WarehouseController');
Route::resource('/mark', 'Administration\MarkController');

Route::resource('/city', 'Administration\CityController');

Route::resource('/user', 'Security\UserController');
Route::resource('/profile', 'Security\ProfileController');
Route::resource('/permission', 'Security\PermissionController');

Route::resource('/entry', 'Inventory\EntryController');
Route::get('/entry/{id}/consecutive', ['uses' => 'Inventory\EntryController@getConsecutive']);
Route::get('/entry/{id}/detail', ['uses' => 'Inventory\EntryController@getDetail']);
Route::post('/entry/storeDetail', 'Inventory\EntryController@storeDetail');
Route::put('/entry/detail/{id}', 'Inventory\EntryController@updateDetail');
Route::delete('/entry/detail/{id}', 'Inventory\EntryController@destroyDetail');

Route::resource('/departure', 'Inventory\DepartureController');
Route::get('/departure/{id}/consecutive', ['uses' => 'Inventory\DepartureController@getConsecutive']);
Route::get('/departure/{id}/quantity', ['uses' => 'Inventory\DepartureController@getQuantity']);
Route::get('/departure/{id}/detail', ['uses' => 'Inventory\DepartureController@getDetail']);
Route::post('/departure/storeDetail', 'Inventory\DepartureController@storeDetail');
Route::put('/departure/detail/{id}', 'Inventory\DepartureController@updateDetail');
Route::delete('/departure/detail/{id}', 'Inventory\DepartureController@destroyDetail');

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

Route::get('/api/listMark', function() {
    return Datatables::eloquent(Models\Administration\Mark::query())->make(true);
});

Route::get('/api/listEntry', function() {
    return Datatables::eloquent(Models\Inventory\Entry::query())->make(true);
});
Route::get('/api/listDeparture', function() {
    return Datatables::eloquent(Models\Inventory\Departure::query())->make(true);
});
Route::get('/api/listCity', function() {
    return Datatables::eloquent(Models\Administration\City::query())->make(true);
});
Route::get('/api/listProfile', function() {
    return Datatables::eloquent(Models\Security\Profile::query())->make(true);
});

