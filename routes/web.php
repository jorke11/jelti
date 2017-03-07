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

Route::post('/product/StoreSpecial', 'Administration\ProductController@storeSpecial');


Route::resource('/supplier', 'Administration\SupplierController');
Route::post('/supplier/upload', 'Administration\SupplierController@uploadImage');
Route::put('/supplier/checkmain/{id}', 'Administration\SupplierController@checkMain');
Route::delete('/supplier/deleteImage/{id}', 'Administration\SupplierController@deleteImage');
Route::get('/supplier/getImages/{id}', 'Administration\SupplierController@getImages');

Route::post('/supplier/StoreSpecial', 'Administration\SupplierController@storeSpecial');
Route::put('/supplier/updatePrice/{id}', 'Administration\SupplierController@updatePrice');
Route::post('/supplier/StoreBranch', 'Administration\SupplierController@storeBranch');
Route::delete('/supplier/deleteBranch/{id}', 'Administration\SupplierController@deleteBranch');


Route::resource('/stakeholder', 'Administration\StakeholderController');
Route::post('/stakeholder/upload', 'Administration\StakeholderController@uploadImage');
Route::put('/stakeholder/checkmain/{id}', 'Administration\StakeholderController@checkMain');
Route::delete('/stakeholder/deleteImage/{id}', 'Administration\StakeholderController@deleteImage');
Route::get('/stakeholder/getImages/{id}', 'Administration\StakeholderController@getImages');

Route::post('/stakeholder/StoreSpecial', 'Administration\StakeholderController@storeSpecial');
Route::put('/stakeholder/updatePrice/{id}', 'Administration\StakeholderController@updatePrice');
Route::post('/stakeholder/StoreBranch', 'Administration\StakeholderController@storeBranch');
Route::delete('/stakeholder/deleteBranch/{id}', 'Administration\StakeholderController@deleteBranch');

Route::resource('/category', 'Administration\CategoryController');
Route::resource('/puc', 'Administration\PucController');
Route::resource('/warehouse', 'Administration\WarehouseController');
Route::resource('/mark', 'Administration\MarkController');

Route::resource('/city', 'Administration\CityController');
Route::resource('/characteristic', 'Administration\CharacteristicController');

Route::resource('/user', 'Security\UserController');
Route::get('/user/getListPermission/{id}', 'Security\UserController@getPermission');
Route::put('/user/savePermission/{id}', 'Security\UserController@savePermission');

Route::resource('/role', 'Security\RoleController');

Route::resource('/permission', 'Security\PermissionController');
Route::get('/api/listPermission', 'Security\PermissionController@getPermission');
Route::get('/permission/{id}/getMenu', ['uses' => 'Security\PermissionController@getMenu']);


Route::resource('/purchase', 'Invoicing\PurchaseController');
Route::get('/purchase/{id}/consecutive', ['uses' => 'Invoicing\PurchaseController@getConsecutive']);
Route::get('/purchase/{id}/detail', ['uses' => 'Invoicing\PurchaseController@getDetail']);
Route::get('/purchase/{id}/getSupplier', ['uses' => 'Invoicing\PurchaseController@getSupplier']);
Route::get('/purchase/{id}/getProducts', ['uses' => 'Invoicing\PurchaseController@getProducts']);
Route::post('/purchase/storeDetail', 'Invoicing\PurchaseController@storeDetail');
Route::put('/purchase/detail/{id}', 'Invoicing\PurchaseController@updateDetail');
Route::delete('/purchase/detail/{id}', 'Invoicing\PurchaseController@destroyDetail');


Route::resource('/sale', 'Invoicing\SaleController');
Route::get('/sale/{id}/consecutive', ['uses' => 'Invoicing\SaleController@getConsecutive']);
Route::get('/sale/{id}/quantity', ['uses' => 'Invoicing\SaleController@getQuantity']);
Route::get('/sale/{id}/detail', ['uses' => 'Invoicing\SaleController@getDetail']);
Route::post('/sale/storeDetail', 'Invoicing\SaleController@storeDetail');
Route::put('/sale/detail/{id}', 'Invoicing\SaleController@updateDetail');
Route::delete('/sale/detail/{id}', 'Invoicing\SaleController@destroyDetail');
Route::get('/sale/{id}/getDetailProduct', ['uses' => 'Invoicing\SaleController@getDetailProduct']);

Route::resource('/entry', 'Inventory\EntryController');
Route::get('/entry/{id}/consecutive', ['uses' => 'Inventory\EntryController@getConsecutive']);
Route::get('/entry/{id}/getDetailProduct', ['uses' => 'Inventory\EntryController@getDetailProduct']);
Route::get('/entry/{id}/detail', ['uses' => 'Inventory\EntryController@getDetail']);
Route::get('/entry/{id}/getSupplier', ['uses' => 'Inventory\EntryController@getSupplier']);
Route::get('/entry/{id}/getProducts', ['uses' => 'Inventory\EntryController@getProducts']);
Route::post('/entry/storeDetail', 'Inventory\EntryController@storeDetail');
Route::put('/entry/detail/{id}', 'Inventory\EntryController@updateDetail');
Route::delete('/entry/detail/{id}', 'Inventory\EntryController@destroyDetail');
Route::post('/entry/setPurchase/', 'Inventory\EntryController@sendPurchase');


Route::resource('/departure', 'Inventory\DepartureController');
Route::get('/departure/{id}/consecutive', ['uses' => 'Inventory\DepartureController@getConsecutive']);
Route::get('/departure/{id}/quantity', ['uses' => 'Inventory\DepartureController@getQuantity']);
Route::get('/departure/{id}/getDetailProduct', ['uses' => 'Inventory\DepartureController@getDetailProduct']);
Route::get('/departure/{id}/detail', ['uses' => 'Inventory\DepartureController@getDetail']);
Route::get('/departure/{id}/editExt', ['uses' => 'Inventory\DepartureController@getOrderExt']);
Route::post('/departure/storeDetail', 'Inventory\DepartureController@storeDetail');
Route::put('/departure/detail/{id}', 'Inventory\DepartureController@updateDetail');
Route::delete('/departure/detail/{id}', 'Inventory\DepartureController@destroyDetail');
Route::get('/departure/getOrder/{id}', 'Inventory\DepartureController@showOrder');
Route::post('/departure/storeExt', 'Inventory\DepartureController@storeExtern');
Route::post('/departure/setSale/', 'Inventory\DepartureController@setSale');
Route::get('/departure/{id}/getInvoice', ['uses' => 'Inventory\DepartureController@getInvoice']);

Route::get('/departure/{id}/getInvoiceHtml', ['uses' => 'Inventory\DepartureController@getInvoiceHtml']);

Route::resource('/order', 'Inventory\OrderController');
Route::get('/order/{id}/consecutive', ['uses' => 'Inventory\OrderController@getConsecutive']);
Route::get('/order/{id}/quantity', ['uses' => 'Inventory\OrderController@getQuantity']);
Route::get('/order/{id}/getDetailProduct', ['uses' => 'Inventory\OrderController@getDetailProduct']);
Route::get('/order/{id}/detail', ['uses' => 'Inventory\OrderController@getDetail']);
Route::post('/order/storeDetail', 'Inventory\OrderController@storeDetail');
Route::put('/order/detail/{id}', 'Inventory\OrderController@updateDetail');
Route::delete('/order/detail/{id}', 'Inventory\OrderController@destroyDetail');
Route::get('/order/{id}/getClient', ['uses' => 'Inventory\OrderController@getClient']);



Route::get('/api/listCategory', function() {
    return Datatables::eloquent(Models\Administration\Categories::query())->make(true);
});
Route::get('/api/listCharacterist', function() {
    return Datatables::eloquent(Models\Administration\Characteristic::query())->make(true);
});

Route::get('/api/listSupplier', function() {
    return Datatables::queryBuilder(
                    DB::table('vsupplier')
            )->make(true);
});

Route::get('/api/listSupplier', function() {
    return Datatables::queryBuilder(
                    DB::table('vsupplier')
            )->make(true);
});
Route::get('/api/listStakeholder', function() {
    return Datatables::queryBuilder(
                    DB::table('vstakeholder')
            )->make(true);
});
Route::get('/api/listProduct', function() {
    return Datatables::eloquent(Models\Administration\Products::query())->make(true);
});
Route::get('/api/listWarehouse', function() {
    return Datatables::eloquent(Models\Administration\Warehouses::query())->make(true);
});

Route::get('/api/listMark', function() {
    return Datatables::eloquent(Models\Administration\Mark::query())->make(true);
});

Route::get('/api/listPurchase', function() {
    return Datatables::eloquent(Models\Invoicing\Purchases::query())->make(true);
});
Route::get('/api/listSale', function() {
    return Datatables::eloquent(Models\Invoicing\Sales::query())->make(true);
});
Route::get('/api/listEntry', function() {
    return Datatables::eloquent(Models\Inventory\Entries::query())->make(true);
});
Route::get('/api/listDeparture', function() {
    return Datatables::eloquent(Models\Inventory\Departures::query())->make(true);
});

Route::get('/api/listOrder', function() {
    return Datatables::eloquent(Models\Inventory\Orders::query())->make(true);
});
Route::get('/api/listCity', function() {
    return Datatables::eloquent(Models\Administration\Cities::query())->make(true);
});
Route::get('/api/listRole', function() {
    return Datatables::eloquent(Models\Security\Roles::query())->make(true);
});

Route::get('/api/listUser', function() {
    return Datatables::eloquent(Models\Security\Users::query())->make(true);
});
Route::get('/api/listPuc', function() {
    return Datatables::eloquent(Models\Administration\Puc::query())->make(true);
});

Route::get('/stock', 'Inventory\StockController@index');
Route::get('/api/listStock', 'Inventory\StockController@getStock');

Route::get('/api/listSpecial', 'Administration\SupplierController@getSpecial');
Route::get('/api/listBranch', 'Administration\SupplierController@getBranch');

Route::get('/api/listMenu', 'DashboardController@getMenu');

Route::get('/api/getCity', 'Administration\SeekController@getCity');
Route::get('/api/getSupplier', 'Administration\SeekController@getSupplier');
Route::get('/api/getCharacteristic', 'Administration\SeekController@getCharacteristic');
Route::get('/api/getClient', 'Administration\SeekController@getClient');
Route::get('/api/getWarehouse', 'Administration\SeekController@getWarehouse');
Route::get('/api/getResponsable', 'Administration\SeekController@getResponsable');
Route::get('/api/getProduct', 'Administration\SeekController@getProduct');
Route::get('/api/getCategory', 'Administration\SeekController@getCategory');
Route::get('/api/getCommercial', 'Administration\SeekController@getCommercial');
Route::get('/api/getBranch', 'Administration\SeekController@getBranch');
Route::get('/api/getAccount', 'Administration\SeekController@getAccount');




