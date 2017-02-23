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
Route::get('/summary', 'Billing\SummaryController@index');

Route::resource('/product', 'Administration\ProductController');
Route::post('/product/upload', 'Administration\ProductController@uploadImage');
Route::put('/product/checkmain/{id}', 'Administration\ProductController@checkMain');
Route::delete('/product/deleteImage/{id}', 'Administration\ProductController@deleteImage');
Route::get('/product/getImages/{id}', 'Administration\ProductController@getImages');

Route::resource('/supplier', 'Administration\SupplierController');
Route::post('/supplier/upload', 'Administration\SupplierController@uploadImage');
Route::put('/supplier/checkmain/{id}', 'Administration\SupplierController@checkMain');
Route::delete('/supplier/deleteImage/{id}', 'Administration\SupplierController@deleteImage');
Route::get('/supplier/getImages/{id}', 'Administration\SupplierController@getImages');

Route::resource('/category', 'Administration\CategoryController');
Route::resource('/puc', 'Administration\PucController');
Route::resource('/warehouse', 'Administration\WarehouseController');
Route::resource('/mark', 'Administration\MarkController');

Route::resource('/city', 'Administration\CityController');

Route::resource('/user', 'Security\UserController');
Route::get('/user/getListPermission/{id}', 'Security\UserController@getPermission');
Route::put('/user/savePermission/{id}', 'Security\UserController@savePermission');

Route::resource('/role', 'Security\RoleController');

Route::resource('/permission', 'Security\PermissionController');
Route::get('/api/listPermission', 'Security\PermissionController@getPermission');
Route::get('/permission/{id}/getMenu', ['uses' => 'Security\PermissionController@getMenu']);


Route::resource('/purchage', 'Invoicing\PurchageController');
Route::get('/purchage/{id}/consecutive', ['uses' => 'Invoicing\PurchageController@getConsecutive']);
Route::get('/purchage/{id}/detail', ['uses' => 'Invoicing\PurchageController@getDetail']);
Route::get('/purchage/{id}/getSupplier', ['uses' => 'Invoicing\PurchageController@getSupplier']);
Route::get('/purchage/{id}/getProducts', ['uses' => 'Invoicing\PurchageController@getProducts']);
Route::post('/purchage/storeDetail', 'Invoicing\PurchageController@storeDetail');
Route::put('/purchage/detail/{id}', 'Invoicing\PurchageController@updateDetail');
Route::delete('/purchage/detail/{id}', 'Invoicing\PurchageController@destroyDetail');


Route::resource('/sale', 'Invoicing\SaleController');
Route::get('/sale/{id}/consecutive', ['uses' => 'Invoicing\SaleController@getConsecutive']);
Route::get('/sale/{id}/quantity', ['uses' => 'Invoicing\SaleController@getQuantity']);
Route::get('/sale/{id}/detail', ['uses' => 'Invoicing\SaleController@getDetail']);
Route::post('/sale/storeDetail', 'Invoicing\SaleController@storeDetail');
Route::put('/sale/detail/{id}', 'Invoicing\SaleController@updateDetail');
Route::delete('/sale/detail/{id}', 'Invoicing\SaleController@destroyDetail');


Route::resource('/entry', 'Inventory\EntryController');
Route::get('/entry/{id}/consecutive', ['uses' => 'Inventory\EntryController@getConsecutive']);
Route::get('/entry/{id}/getDetailProduct', ['uses' => 'Inventory\EntryController@getDetailProduct']);
Route::get('/entry/{id}/detail', ['uses' => 'Inventory\EntryController@getDetail']);
Route::get('/entry/{id}/getSupplier', ['uses' => 'Inventory\EntryController@getSupplier']);
Route::get('/entry/{id}/getProducts', ['uses' => 'Inventory\EntryController@getProducts']);
Route::post('/entry/storeDetail', 'Inventory\EntryController@storeDetail');
Route::put('/entry/detail/{id}', 'Inventory\EntryController@updateDetail');
Route::delete('/entry/detail/{id}', 'Inventory\EntryController@destroyDetail');


Route::resource('/departure', 'Inventory\DepartureController');
Route::get('/departure/{id}/consecutive', ['uses' => 'Inventory\DepartureController@getConsecutive']);
Route::get('/departure/{id}/quantity', ['uses' => 'Inventory\DepartureController@getQuantity']);
Route::get('/departure/{id}/getDetailProduct', ['uses' => 'Inventory\DepartureController@getDetailProduct']);
Route::get('/departure/{id}/detail', ['uses' => 'Inventory\DepartureController@getDetail']);
Route::post('/departure/storeDetail', 'Inventory\DepartureController@storeDetail');
Route::put('/departure/detail/{id}', 'Inventory\DepartureController@updateDetail');
Route::delete('/departure/detail/{id}', 'Inventory\DepartureController@destroyDetail');


Route::resource('/service', 'Inventory\DepartureController');
Route::get('/service/{id}/consecutive', ['uses' => 'Inventory\DepartureController@getConsecutive']);
Route::get('/service/{id}/quantity', ['uses' => 'Inventory\DepartureController@getQuantity']);
Route::get('/service/{id}/detail', ['uses' => 'Inventory\DepartureController@getDetail']);
Route::post('/service/storeDetail', 'Inventory\DepartureController@storeDetail');
Route::put('/service/detail/{id}', 'Inventory\DepartureController@updateDetail');
Route::delete('/service/detail/{id}', 'Inventory\DepartureController@destroyDetail');

Route::get('/api/listCategory', function() {
    return Datatables::eloquent(Models\Administration\Category::query())->make(true);
});

Route::get('/api/listSupplier', function() {
    return Datatables::queryBuilder(
                    DB::table('vsupplier')
            )->make(true);
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

Route::get('/api/listPurchage', function() {
    return Datatables::eloquent(Models\Invoicing\Purchage::query())->make(true);
});
Route::get('/api/listSale', function() {
    return Datatables::eloquent(Models\Invoicing\Sale::query())->make(true);
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
Route::get('/api/listRole', function() {
    return Datatables::eloquent(Models\Security\Role::query())->make(true);
});

Route::get('/api/listUser', function() {
    return Datatables::eloquent(Models\Security\User::query())->make(true);
});
Route::get('/api/listPuc', function() {
    return Datatables::eloquent(Models\Administration\Puc::query())->make(true);
});

Route::get('/api/listMenu', 'DashboardController@getMenu');

Route::get('/api/getCity', 'Administration\SeekController@getCity');
Route::get('/api/getSupplier', 'Administration\SeekController@getSupplier');
Route::get('/api/getWarehouse', 'Administration\SeekController@getWarehouse');
Route::get('/api/getResponsable', 'Administration\SeekController@getResponsable');
Route::get('/api/getProduct', 'Administration\SeekController@getProduct');




