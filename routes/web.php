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
Route::get('/summary', 'Invoicing\SummaryController@index');

Route::get('/resize', 'ToolController@index');

Route::resource('/consecutive', 'Administration\ConsecutiveController');
Route::resource('/creditNote', 'Sales\CreditnoteController');


Route::resource('/product', 'Administration\ProductController');
Route::post('/product/upload', 'Administration\ProductController@uploadImage');
Route::put('/product/checkmain/{id}', 'Administration\ProductController@checkMain');
Route::delete('/product/deleteImage/{id}', 'Administration\ProductController@deleteImage');
Route::get('/product/getImages/{id}', 'Administration\ProductController@getImages');
Route::post('/product/StoreSpecial', 'Administration\ProductController@storeSpecial');
Route::post('/product/uploadExcel', 'Administration\ProductController@storeExcel');

Route::resource('/stakeholder', 'Administration\StakeholderController');
Route::post('/stakeholder/upload', 'Administration\StakeholderController@uploadImage');
Route::post('/stakeholder/uploadExcel', 'Administration\StakeholderController@uploadExcel');
Route::post('/stakeholder/uploadClient', 'Administration\StakeholderController@uploadclient');
Route::put('/stakeholder/checkmain/{id}', 'Administration\StakeholderController@checkMain');
Route::delete('/stakeholder/deleteImage/{id}', 'Administration\StakeholderController@deleteImage');
Route::get('/stakeholder/getImages/{id}', 'Administration\StakeholderController@getImages');

Route::post('/stakeholder/StoreSpecial', 'Administration\StakeholderController@storeSpecial');
Route::put('/stakeholder/updatePrice/{id}', 'Administration\StakeholderController@updatePrice');
Route::post('/stakeholder/StoreBranch', 'Administration\StakeholderController@storeBranch');
Route::delete('/stakeholder/deleteBranch/{id}', 'Administration\StakeholderController@deleteBranch');
Route::post('/stakeholder/addChage', 'Administration\StakeholderController@addChanges');

Route::post('/stakeholder/addTax', 'Administration\StakeholderController@storeTax');
Route::put('/stakeholder/UpdateTax', 'Administration\StakeholderController@updateTax');
Route::delete('/stakeholder/deleteTax/{id}', 'Administration\StakeholderController@deleteTax');


Route::resource('/clients', 'Clients\ClientController');
Route::post('/clients/upload', 'Clients\ClientController@uploadImage');
Route::post('/clients/uploadExcel', 'Clients\ClientController@uploadExcel');
Route::post('/clients/uploadClient', 'Clients\ClientController@uploadclient');
Route::put('/clients/checkmain/{id}', 'Clients\ClientController@checkMain');
Route::delete('/clients/deleteImage/{id}', 'Clients\ClientController@deleteImage');
Route::get('/clients/getImages/{id}', 'Clients\ClientController@getImages');

Route::post('/clients/StoreSpecial', 'Clients\ClientController@storeSpecial');
Route::put('/clients/updatePrice/{id}', 'Clients\ClientController@updatePrice');
Route::post('/clients/StoreBranch', 'Clients\ClientController@storeBranch');
Route::delete('/clients/deleteBranch/{id}', 'Clients\ClientController@deleteBranch');
Route::post('/clients/addChage', 'Clients\ClientController@addChanges');

Route::post('/clients/addTax', 'Clients\ClientController@storeTax');
Route::put('/clients/UpdateTax', 'Clients\ClientController@updateTax');
Route::delete('/clients/deleteTax/{id}', 'Clients\ClientController@deleteTax');


Route::resource('/category', 'Administration\CategoryController');
Route::resource('/puc', 'Administration\PucController');
Route::resource('/warehouse', 'Administration\WarehouseController');
Route::resource('/mark', 'Administration\MarkController');
Route::resource('/email', 'Administration\EmailController');
Route::post('/email/detail', 'Administration\EmailController@storeDetail');
Route::put('/email/detail/{id}', 'Administration\EmailController@updateDetail');
Route::get('/email/detail/{id}/edit', 'Administration\EmailController@editDetail');
Route::delete('/email/detail/{id}', 'Administration\EmailController@destroyDetail');

Route::resource('/city', 'Administration\CityController');
Route::post('/city/uploadExcel', 'Administration\CityController@storeExcel');

Route::resource('/department', 'Administration\DepartmentController');
Route::post('/department/uploadExcel', 'Administration\DepartmentController@storeExcel');

Route::post('/user/uploadExcel', 'Security\UserController@storeExcel');
Route::put('/user', 'Security\UserController@store');

Route::resource('/characteristic', 'Administration\CharacteristicController');

Route::resource('/user', 'Security\UserController');
Route::get('/user/getListPermission/{id}', 'Security\UserController@getPermission');
Route::put('/user/savePermission/{id}', 'Security\UserController@savePermission');

Route::resource('/role', 'Security\RoleController');
Route::put('/role/savePermission/{id}', 'Security\RoleController@savePermissionRole');

Route::get('/getPermissionRole/{id}', 'Security\RoleController@getPermissionRole');

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
Route::get('/purchase/{id}/getDetailProduct', ['uses' => 'Inventory\StockController@getDetailProduct']);
Route::post('/purchase/sendPurchase', 'Invoicing\PurchaseController@sendPurchase');

Route::resource('/sale', 'Invoicing\SaleController');
Route::get('/sale/{id}/consecutive', ['uses' => 'Invoicing\SaleController@getConsecutive']);
Route::get('/sale/{id}/quantity', ['uses' => 'Invoicing\SaleController@getQuantity']);
Route::get('/sale/{id}/detail', ['uses' => 'Invoicing\SaleController@getDetail']);
Route::post('/sale/storeDetail', 'Invoicing\SaleController@storeDetail');
Route::put('/sale/detail/{id}', 'Invoicing\SaleController@updateDetail');
Route::delete('/sale/detail/{id}', 'Invoicing\SaleController@destroyDetail');
Route::get('/sale/{id}/getDetailProduct', ['uses' => 'Inventory\StockController@getDetailProduct']);

Route::put('/checkedSale/{id}', 'Invoicing\SaleController@checkedSale');

Route::resource('/entry', 'Inventory\EntryController');
Route::get('/entry/{id}/consecutive', ['uses' => 'Inventory\EntryController@getConsecutive']);
Route::get('/entry/{id}/getDetailProduct', ['uses' => 'Inventory\StockController@getDetailProduct']);
Route::get('/entry/{id}/detail', ['uses' => 'Inventory\EntryController@getDetail']);
Route::get('/entry/{id}/getSupplier', ['uses' => 'Inventory\EntryController@getSupplier']);
Route::get('/entry/{id}/getProducts', ['uses' => 'Inventory\EntryController@getProducts']);
Route::get('/entry/{id}/getDetailPurchase', ['uses' => 'Inventory\EntryController@getPurchase']);

Route::post('/entry/storeDetail', 'Inventory\EntryController@storeDetail');
Route::put('/entry/detail/{id}', 'Inventory\EntryController@updateDetail');
Route::delete('/entry/detail/{id}', 'Inventory\EntryController@destroyDetail');
Route::post('/entry/setPurchase', 'Inventory\EntryController@sendPurchase');
Route::post('/entry/uploadExcel', 'Inventory\EntryController@storeExcel');


Route::resource('/departure', 'Inventory\DepartureController');
Route::get('/departure/{id}/consecutive', ['uses' => 'Inventory\DepartureController@getConsecutive']);
Route::get('/departure/{id}/quantity', ['uses' => 'Inventory\DepartureController@getQuantity']);
Route::get('/departure/{id}/getDetailProduct', ['uses' => 'Inventory\StockController@getDetailProduct']);
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
Route::get('/departure/{id}/detailAll/', 'Inventory\DepartureController@getAllDetail');
Route::put('/departure/generateInvoice/{id}', 'Inventory\DepartureController@generateInvoice');

Route::get('/departure/{id}/getClient', ['uses' => 'Inventory\DepartureController@getClient']);
Route::get('/departure/{id}/getBranch', ['uses' => 'Inventory\DepartureController@getBranch']);
Route::post('/departure/uploadExcel', 'Inventory\DepartureController@storeExcel');


Route::resource('/order', 'Inventory\OrderController');
Route::get('/order/{id}/consecutive', ['uses' => 'Inventory\OrderController@getConsecutive']);
Route::get('/order/{id}/quantity', ['uses' => 'Inventory\OrderController@getQuantity']);
Route::get('/order/{id}/getDetailProduct', ['uses' => 'Inventory\StockController@getDetailProduct']);
Route::get('/order/{id}/detail', ['uses' => 'Inventory\OrderController@getDetail']);
Route::post('/order/storeDetail', 'Inventory\OrderController@storeDetail');
Route::put('/order/detail/{id}', 'Inventory\OrderController@updateDetail');
Route::delete('/order/detail/{id}', 'Inventory\OrderController@destroyDetail');
Route::get('/order/{id}/getClient', ['uses' => 'Inventory\OrderController@getClient']);
/**
 * Shopping cart
 */
Route::get('/shopping', 'Shopping\ShoppingController@index');
Route::get('/shopping/{id}', 'Shopping\ShoppingController@getDetailProduct');
Route::get('/getCategories', 'Shopping\ShoppingController@getCategories');
Route::get('/productDetail/{id}', 'Shopping\ShoppingController@getProduct');
Route::post('/addComment', 'Shopping\ShoppingController@addComment');
Route::get('/getComment/{id}', 'Shopping\ShoppingController@getComment');


Route::post('/addDetail', 'Shopping\ShoppingController@managementOrder');
Route::get('/getCounter', 'Shopping\ShoppingController@getCountOrders');

Route::get('/payment', 'Shopping\PaymentController@index');
Route::get('/getDetail', 'Shopping\PaymentController@getDetail');
Route::delete('/deleteDetail/{id}', 'Shopping\PaymentController@deleteItem');


Route::resource('/prospect', 'Seller\ProspectsController');
Route::post('/prospect/convert', 'Seller\ProspectsController@convertToClient');


Route::resource('/activity', 'Seller\ActivityController');
Route::resource('/contact', 'Administration\ContactController');
Route::resource('/fulfillment', 'Seller\FulfillmentController');
Route::get('/fulfillment/getInfo/{year}/{month}', 'Seller\FulfillmentController@getInfo');
Route::get('/fulfillment/getMax/{id}', 'Seller\FulfillmentController@getMax');
Route::get('/fulfillment/getSales/{id}', 'Seller\FulfillmentController@getSales');
Route::post('/fulfillment/addTarjet', 'Seller\FulfillmentController@setTarjet');
Route::put('/fulfillment/editTarjet/{id}', 'Seller\FulfillmentController@updateTarjet');

Route::get('/fulfillment/getDetail/{id}', 'Seller\FulfillmentController@getDetail');

Route::put('/fulfillment/updateDetail/{id}', 'Seller\FulfillmentController@updateDetail');
Route::post('/fulfillment/addCommercial', 'Seller\FulfillmentController@store');


Route::get('/comments', 'MainController@getcomments');
Route::get('/comments/list/{id}', 'MainController@listComments');


Route::resource('/ticket', 'Administration\TicketController');
Route::resource('/ticket/addComment', 'Administration\TicketController@addComment');
Route::resource('/parameter', 'Administration\ParametersController');


Route::get('/reportSales', 'Report\SalesController@index');



Route::get('/api/listCategory', function() {
    return Datatables::queryBuilder(DB::table("categories")->orderBy("order", "asc"))->make(true);
});
Route::get('/api/listCharacterist', function() {
    return Datatables::eloquent(Models\Administration\Characteristic::query())->make(true);
});

Route::get('/api/lisCLient', function() {
    return Datatables::queryBuilder(
                    DB::table('vclient')
            )->make(true);
});

Route::get('/api/listParameter', function() {
    return Datatables::queryBuilder(
                    DB::table('parameters')->orderBy("id", "asc")
            )->make(true);
});

Route::get('/api/listTicket', function() {
    return Datatables::queryBuilder(
                    DB::table('tickets')
            )->make(true);
});

Route::get('/api/listSupplier', function() {

    $query = DB::table('vsupplier');

//    $query = DB::table('stakeholder')
//            ->select(
//                    "stakeholder.business_name", "stakeholder.id", "stakeholder.name", "stakeholder.last_name", "stakeholder.document", "stakeholder.email", "stakeholder.address", "stakeholder.phone", "stakeholder.contact", "stakeholder.phone_contact", "stakeholder.term", "cities.description as city", "stakeholder.web_site", "typeperson.description as typeperson", "typeregime.description as typeregime", "typestakeholder.description as type_stakeholder", "status.description as status_id")
//            ->leftjoin("cities", "cities.id", "stakeholder.city_id")
//            ->leftjoin("parameters as typeregime", DB::raw("typeregime.code"), "=", DB::raw("stakeholder.type_regime_id and typeregime.group='typeregimen'"))
//            ->leftjoin("parameters as typeperson", DB::raw("typeperson.code"), "=", DB::raw("stakeholder.type_person_id and typeperson.group='typeperson'"))
//            ->leftjoin("parameters as typestakeholder", DB::raw("typestakeholder.code"), "=", DB::raw("stakeholder.type_stakeholder and typestakeholder.group='typestakeholder'"))
//            ->leftjoin("parameters as status", DB::raw("status.code"), "=", DB::raw("stakeholder.status_id and status.group='generic'"));
    if (Auth::user()->role_id != 1 && Auth::user()->role_id != 5) {
        $query->where("responsible_id", Auth::user()->id);
    }
    return Datatables::queryBuilder($query)->make(true);
});

Route::get('/api/listClient', function() {

    $query = DB::table('vclient');

//    $query = DB::table('stakeholder')
//            ->select(
//                    "stakeholder.business_name", "stakeholder.id", "stakeholder.name", "stakeholder.last_name", "stakeholder.document", "stakeholder.email", "stakeholder.address", "stakeholder.phone", "stakeholder.contact", "stakeholder.phone_contact", "stakeholder.term", "cities.description as city", "stakeholder.web_site", "typeperson.description as typeperson", "typeregime.description as typeregime", "typestakeholder.description as type_stakeholder", "status.description as status_id")
//            ->leftjoin("cities", "cities.id", "stakeholder.city_id")
//            ->leftjoin("parameters as typeregime", DB::raw("typeregime.code"), "=", DB::raw("stakeholder.type_regime_id and typeregime.group='typeregimen'"))
//            ->leftjoin("parameters as typeperson", DB::raw("typeperson.code"), "=", DB::raw("stakeholder.type_person_id and typeperson.group='typeperson'"))
//            ->leftjoin("parameters as typestakeholder", DB::raw("typestakeholder.code"), "=", DB::raw("stakeholder.type_stakeholder and typestakeholder.group='typestakeholder'"))
//            ->leftjoin("parameters as status", DB::raw("status.code"), "=", DB::raw("stakeholder.status_id and status.group='generic'"));
    if (Auth::user()->role_id != 1 && Auth::user()->role_id != 5) {
        $query->where("responsible_id", Auth::user()->id);
    }
    return Datatables::queryBuilder($query)->make(true);
});

Route::get('/api/listProduct', function() {
    $query = DB::table('vproducts');
    return Datatables::queryBuilder($query)->make(true);
});

Route::get('/api/listConsecutive', function() {
    return Datatables::eloquent(models\Administration\Consecutives::query())->make(true);
});

Route::get('/api/listWarehouse', function() {
    $query = DB::table("warehouses")
            ->select("warehouses.id", "warehouses.description", "warehouses.address", "cities.description as city", DB::raw("coalesce(users.name) || coalesce(users.last_name) as responsible"))
            ->leftjoin("users", "users.id", "warehouses.responsible_id")
            ->leftjoin("cities", "cities.id", "warehouses.city_id");
    return Datatables::queryBuilder($query)->make(true);
});

Route::get('/api/listMark', function() {
    return Datatables::eloquent(Models\Administration\Mark::query())->make(true);
});

Route::get('/api/listEmail', function() {
    return Datatables::eloquent(Models\Administration\Email::query())->make(true);
});

Route::get('/api/listProspect', function() {
    return Datatables::eloquent(Models\Seller\Prospect::query())->make(true);
});

Route::get('/api/listActivity', function() {
    return Datatables::eloquent(Models\Seller\Activity::query())->make(true);
});

Route::get('/api/listContact', function() {
    return Datatables::eloquent(Models\Administration\Contact::query())->make(true);
});

Route::get('/api/listPurchase', function() {

    $query = DB::table("vpurchases");

    if (Auth::user()->role_id != 1 && Auth::user()->role_id != 5) {
        $query->where("responsible_id", Auth::user()->id);
    }

    return Datatables::queryBuilder($query)->make(true);
});

Route::get('/api/listSale', function() {

    $sql = DB::table('sales')
            ->select("sales.id", "sales.consecutive", DB::raw("coalesce(sales.description,'') as description"), "sales.created", "departures.consecutive as departure", "warehouses.description as warehouse")
            ->join("departures", "departures.id", "sales.departure_id")
            ->join("warehouses", "warehouses.id", "sales.warehouse_id");

    return Datatables::queryBuilder($sql)->make(true);
});
Route::get('/api/listEntry', function() {

    $query = DB::table('entries')
            ->select("entries.id", "entries.consecutive", "entries.description", "entries.created_at", "entries.invoice", "warehouses.description as warehouse", "cities.description as city", DB::raw("coalesce(parameters.description,'') as status"))
            ->join("warehouses", "warehouses.id", "entries.warehouse_id")
            ->leftjoin("cities", "cities.id", "entries.city_id")
            ->leftjoin("parameters", "parameters.code", "entries.status_id")
            ->where("parameters.group", "entry");

//    if (Auth::user()->role_id != 1 && Auth::user()->role_id != 5) {
//        $query->where("entries.responsible_id", Auth::user()->id);
//    }

    return Datatables::queryBuilder($query)->make(true);
});

Route::get('/api/listDeparture', function() {

    $query = DB::table('vdepartures');

    if (Auth::user()->role_id != 1 && Auth::user()->role_id != 5) {
        $query->where("responsible_id", Auth::user()->id);
    }

    return Datatables::queryBuilder($query)->make(true);
});

Route::get('/api/listOrder', function() {
    return Datatables::eloquent(Models\Inventory\Orders::query())->make(true);
});

Route::get('/api/listCity', function() {
    $query = DB::table("vcities");
    return Datatables::queryBuilder($query)->make(true);
});

Route::get('/api/listDepartment', function() {
    return Datatables::eloquent(Models\Administration\Department::query())->make(true);
});

Route::get('/api/listRole', function() {
    return Datatables::eloquent(Models\Security\Roles::query())->make(true);
});

Route::get('/api/listUser', function() {
    return Datatables::queryBuilder(
                    DB::table("users")
                            ->select("users.id", "users.name", "users.email", DB::raw("coalesce(users.document::text,'') as document"), "roles.description as role", "stakeholder.business_name as stakeholder", "cities.description as city", "parameters.description as status")
                            ->join("roles", "roles.id", "users.role_id")
                            ->leftjoin("stakeholder", "stakeholder.id", "users.stakeholder_id")
                            ->leftjoin("cities", "cities.id", "users.city_id")
                            ->join("parameters", "parameters.code", DB::raw("users.status_id and parameters.group='generic'"))
            )->make(true);
});

Route::get('/api/listPuc', function() {
    return Datatables::eloquent(Models\Administration\Puc::query())->make(true);
});

Route::get('/stock', 'Inventory\StockController@index');
Route::get('/api/listStock', 'Inventory\StockController@getStock');

Route::get('/api/listSpecial', 'Administration\StakeholderController@getSpecial');
Route::get('/api/listBranch', 'Administration\StakeholderController@getBranch');

Route::get('/api/listMenu', 'DashboardController@getMenu');
Route::get('/user/savePermission/{id}', 'Security\UserController@savePermission');
Route::get('/logout', 'Security\UserController@logOut');


Route::get('/api/getCity', 'Administration\SeekController@getCity');
Route::get('/api/getDepartment', 'Administration\SeekController@getDepartment');
Route::get('/api/getSupplier', 'Administration\SeekController@getSupplier');
Route::get('/api/getStakeholder', 'Administration\SeekController@getStakeholder');
Route::get('/api/getCharacteristic', 'Administration\SeekController@getCharacteristic');
Route::get('/api/getClient', 'Administration\SeekController@getClient');
Route::get('/api/getContact', 'Administration\SeekController@getContact');
Route::get('/api/getWarehouse', 'Administration\SeekController@getWarehouse');
Route::get('/api/getResponsable', 'Administration\SeekController@getResponsable');
Route::get('/api/getProduct', 'Administration\SeekController@getProduct');
Route::get('/api/getCategory', 'Administration\SeekController@getCategory');
Route::get('/api/getNotification', 'Administration\SeekController@getNotification');
Route::get('/api/getCommercial', 'Administration\SeekController@getCommercial');
Route::get('/api/getBranch', 'Administration\SeekController@getBranch');
Route::get('/api/getAccount', 'Administration\SeekController@getAccount');

Route::get('/report/sale/{init}/{end}', 'Report\SalesController@getTotalSales');
Route::get('/report/fulfillmentSup/{init}/{end}', 'Report\SalesController@getFulfillmentSup');
Route::get('/report/fulfillmentCli/{init}/{end}', 'Report\SalesController@getFulfillmentCli');


Route::get('/briefcase', 'Sales\BriefcaseController@index');

Route::get('/briefcase/getInvoices', function() {
    return Datatables::queryBuilder(
                    DB::table("vbriefcase")
            )->make(true);
});



