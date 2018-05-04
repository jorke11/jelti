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

Auth::routes();

Route::group(['namespace' => 'Api'], function () {
    Route::post('/user/login', 'UserController@login');
    Route::post('/details', 'UserController@details')->middleware('auth:api');
});


Route::get('/', function ($search = null) {
//    dd($_GET);

    if (isset($_GET["search"])) {
        $subcategory = Models\Administration\Characteristic::where("status_id", 1)->whereNotNull("img")->where("type_subcategory_id", 1)->orderBy("order", "asc")->get();

        $products = DB::table("vproducts")->whereNotNull("image")->whereNotNull("warehouse")
                        ->where("title", "ilike", "%" . strtolower($_GET["search"]) . "%")
                        ->Orwhere("supplier", "ilike", "%" . strtolower($_GET["search"]) . "%")
                        ->whereNotNull("image")
                        ->orderBy("title", "desc")->paginate(16);
        $category = Models\Administration\Categories::all();
        return view("Ecommerce.shopping.specific", compact("category", "products", "subcategory"));

//        return view('search', compact("data"));
    } else {

        $category = Models\Administration\Categories::where("status_id", 1)->where("type_category_id", 1)->whereNull("node_id")->OrWhere("node_id", 0)->orderBy("order", "asc")->get();
//    dd($category);
        $newproducts = DB::table("vproducts")->where("status_id", 1)
                ->where("category_id", "<>", -1)
                ->where("category_id", "<>", 19)
                ->whereNotNull("image")
                ->orderBy("supplier", "asc")
                ->orderBy("category_id")
                ->orderBy("reference")
                ->get();

        $subcategory = Models\Administration\Characteristic::where("status_id", 1)->where("type_subcategory_id", 1)->whereNotNull("img")->orderBy("order", "asc")->get();
//    dd($subcategory);

        foreach ($newproducts as $i => $value) {
            $cod = str_replace("]", "", str_replace("[", "", $newproducts[$i]->characteristic));
            if ($cod != '') {
                $cod = array_map('intval', explode(",", $cod));
                $cod = array_filter($cod);
                $cha = null;
                if (count($cod) > 0) {

                    $cha = Models\Administration\Characteristic::whereIn("id", $cod)->get();
                    if (count($cha) == 0) {
                        $cha = null;
                    }
                    $newproducts[$i]->characteristic = $cha;
                }

                $newproducts[$i]->short_description = str_replace("/", "<br>", $newproducts[$i]->short_description);
            } else {
                $newproducts[$i]->characteristic = null;
            }
        }
        return view('page', compact("category", "subcategory", "newproducts"));
    }
});


Route::get("/admins/login", "AdministratorsController@showLoginForm");
Route::post("/admins/login", "AdministratorsController@login");
Route::get("/admins/home", "AdministratorsController@index");

Route::group(["middleware" => ["auth", "client"]], function() {
    Route::get('/home', 'HomeController@index');
});



Route::get('/dash', 'DashboardController@index');
Route::get('/summary', 'Invoicing\SummaryController@index');



Route::resource('/consecutive', 'Administration\ConsecutiveController');

Route::resource('services', 'Suppliers\ServicesController');
Route::resource('/product', 'Administration\ProductController');
Route::post('/product/upload', 'Administration\ProductController@uploadImage');
Route::put('/product/checkmain/{id}', 'Administration\ProductController@checkMain');
Route::delete('/product/deleteImage/{id}', 'Administration\ProductController@deleteImage');
Route::get('/product/getImages/{id}', 'Administration\ProductController@getImages');
Route::post('/product/StoreSpecial', 'Administration\ProductController@storeSpecial');
Route::post('/product/uploadExcel', 'Administration\ProductController@storeExcel');
Route::post('/product/uploadExcelCode', 'Administration\ProductController@storeExcelCode');

Route::resource('/suppliers', 'Suppliers\SupplierController');
Route::post('/suppliers/upload', 'Suppliers\SupplierController@uploadImage');
Route::post('/suppliers/uploadExcel', 'Suppliers\SupplierController@uploadExcel');
Route::post('/suppliers/uploadClient', 'Suppliers\SupplierController@uploadclient');
Route::put('/suppliers/checkmain/{id}', 'Suppliers\SupplierController@checkMain');
Route::delete('/suppliers/deleteImage/{id}', 'Suppliers\SupplierController@deleteImage');
Route::get('/suppliers/getImages/{id}', 'Suppliers\SupplierController@getImages');

Route::post('/suppliers/StoreSpecial', 'Suppliers\SupplierController@storeSpecial');
Route::put('/suppliers/updatePrice/{id}', 'Suppliers\SupplierController@updatePrice');
Route::put('/suppliers/UpdateContact/{id}', 'Suppliers\SupplierController@updateContact');
Route::post('/suppliers/StoreContact', 'Suppliers\SupplierController@storeContact');
Route::delete('/suppliers/deleteContact/{id}', 'Suppliers\SupplierController@deleteContact');
Route::post('/suppliers/addChage', 'Suppliers\SupplierController@addChanges');

Route::get('/suppliers/contact/{id}', 'Suppliers\SupplierController@editContact');

Route::post('/suppliers/addTax', 'Suppliers\SupplierController@storeTax');
Route::put('/suppliers/UpdateTax', 'Suppliers\SupplierController@updateTax');
Route::delete('/suppliers/deleteTax/{id}', 'Suppliers\SupplierController@deleteTax');

Route::resource('/clients', 'Clients\ClientController');
Route::post('/clients/upload', 'Clients\ClientController@uploadImage');
Route::post('/clients/uploadExcel', 'Clients\ClientController@uploadExcel');
Route::post('/clients/uploadClient', 'Clients\ClientController@uploadclient');
Route::put('/clients/checkmain/{id}', 'Clients\ClientController@checkMain');
Route::delete('/clients/deleteImage/{id}', 'Clients\ClientController@deleteImage');
Route::delete('clients/deletePrice/{id}', 'Clients\ClientController@destroyPrice');
Route::get('/clients/getImages/{id}', 'Clients\ClientController@getImages');

Route::post('/clients/StoreSpecial', 'Clients\ClientController@storeSpecial');
Route::put('/clients/updatePrice/{id}', 'Clients\ClientController@updatePrice');
Route::put('/clients/updatePriceId/{id}', 'Clients\ClientController@updatePriceId');
Route::put('/clients/UpdateContact/{id}', 'Clients\ClientController@updateContact');
Route::post('/clients/StoreContact', 'Clients\ClientController@storeContact');
Route::delete('/clients/deleteContact/{id}', 'Clients\ClientController@deleteContact');
Route::post('/clients/addChage', 'Clients\ClientController@addChanges');
Route::get('/clients/contact/{id}', 'Clients\ClientController@editContact');
Route::delete('/clients/branch/{id}', 'Clients\ClientController@destroyBranch');

Route::post('/clients/addTax', 'Clients\ClientController@storeTax');
Route::put('/clients/UpdateTax', 'Clients\ClientController@updateTax');
Route::delete('/clients/deleteTax/{id}', 'Clients\ClientController@deleteTax');
Route::post('/clients/addComment', 'Clients\ClientController@storeComment');
Route::get('/clients/{id}/getBranch', ['uses' => 'Clients\ClientController@getBranch']);
Route::get('/clients/{id}/getBranchId', ['uses' => 'Clients\ClientController@getBranchId']);
Route::get('/clients/{id}/getSpecialId', ['uses' => 'Clients\ClientController@getSpecialId']);
Route::post('/clients/uploadExcelCode', 'Clients\ClientController@storeExcelCode');

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
Route::resource('/characteristic', 'Administration\CharacteristicController');


Route::resource('/purchase', 'Invoicing\PurchaseController');
Route::get('/purchase/{id}/consecutive', ['uses' => 'Invoicing\PurchaseController@getConsecutive']);
Route::get('/purchase/{id}/detail', ['uses' => 'Invoicing\PurchaseController@getDetail']);
Route::get('/purchase/{id}/getSupplier', ['uses' => 'Invoicing\PurchaseController@getSupplier']);
Route::get('/purchase/{id}/getProducts', ['uses' => 'Invoicing\PurchaseController@getProducts']);
Route::post('/purchase/storeDetail', 'Invoicing\PurchaseController@storeDetail');
Route::put('/purchase/detail/{id}', 'Invoicing\PurchaseController@updateDetail');
Route::delete('/purchase/detail/{id}', 'Invoicing\PurchaseController@destroyDetail');
Route::get('/purchase/{id}/getDetailProduct', ['uses' => 'Inventory\StockController@getDetailProductOut']);
Route::post('/purchase/sendPurchase', 'Invoicing\PurchaseController@sendPurchase');
Route::get('/purchase/testNotification/{id}', 'Invoicing\PurchaseController@testNotification');

Route::get('/purchase/{id}/detailAll/', 'Invoicing\PurchaseController@getAllDetail');

Route::put('/purchase/{id}/reverseInvoice', 'Invoicing\PurchaseController@reverse');
Route::get('/reportPurchase', 'Report\PurchaseController@index');

Route::resource('/sale', 'Invoicing\SaleController');
Route::get('/sale/{id}/consecutive', ['uses' => 'Invoicing\SaleController@getConsecutive']);
Route::get('/sale/{id}/quantity', ['uses' => 'Invoicing\SaleController@getQuantity']);
Route::get('/sale/{id}/detail', ['uses' => 'Invoicing\SaleController@getDetail']);
Route::post('/sale/storeDetail', 'Invoicing\SaleController@storeDetail');
Route::put('/sale/detail/{id}', 'Invoicing\SaleController@updateDetail');
Route::delete('/sale/detail/{id}', 'Invoicing\SaleController@destroyDetail');
Route::get('/sale/{id}/getDetailProduct', ['uses' => 'Inventory\StockController@getDetailProduct']);

Route::put('/checkedSale/{id}', 'Invoicing\SaleController@checkedSale');

Route::resource('/transfer', 'Inventory\TransferController');
Route::get('/api/listTransfer', 'Inventory\TransferController@listTable');
Route::get('/transfer/{id}/getDetailProduct', ['uses' => 'Inventory\StockController@getDetailProduct']);
Route::get('/transfer/{id}/detail', ['uses' => 'Inventory\TransferController@getDetail']);
Route::put('/transfer/detail/{id}', 'Inventory\TransferController@updateDetail');
Route::post('/transfer/setSale/', 'Inventory\TransferController@setSale');
Route::get('/transfer/{id}/getProductTransfer', ['uses' => 'Inventory\TransferController@getProducts']);

Route::resource('/entry', 'Inventory\EntryController');
Route::get('/entry/{id}/consecutive', ['uses' => 'Inventory\EntryController@getConsecutive']);
Route::get('/entry/{id}/getDetailProduct', ['uses' => 'Inventory\StockController@getDetailProduct']);
Route::get('/entry/{product_id}/{entry_id}/detail', ['uses' => 'Inventory\EntryController@getDetail']);
Route::get('/entry/{id}/detailAll', ['uses' => 'Inventory\EntryController@getDetailAll']);
Route::get('/entry/{id}/getSupplier', ['uses' => 'Inventory\EntryController@getSupplier']);
Route::get('/entry/{id}/getProducts', ['uses' => 'Inventory\EntryController@getProducts']);
Route::get('/entry/{id}/getDetailPurchase', ['uses' => 'Inventory\EntryController@getPurchase']);

Route::post('/entry/storeDetail', 'Inventory\EntryController@storeDetail');
Route::put('/entry/detail/{id}', 'Inventory\EntryController@updateDetail');
Route::delete('/entry/detail/{id}', 'Inventory\EntryController@destroyDetail');
Route::post('/entry/setPurchase', 'Inventory\EntryController@sendPurchase');
Route::post('/entry/uploadExcel', 'Inventory\EntryController@storeExcel');
Route::put('/entry/{id}/setDetail', 'Inventory\EntryController@setDetail');

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
Route::resource('/prospect', 'Seller\ProspectsController');
Route::post('/prospect/convert', 'Seller\ProspectsController@convertToClient');

Route::resource('/contact', 'Administration\ContactController');

Route::resource('/parameter', 'Administration\ParametersController');


Route::get('/reportSales', 'Report\SalesController@index');

Route::resource('/creditnote', 'Sales\creditnoteController');
Route::get('/creditnote/{id}/getCreditNote', 'Sales\creditnoteController@editCreditNote');
Route::get('/creditnote/{id}/getDetailProduct', ['uses' => 'Inventory\StockController@getDetailProductOut']);
Route::delete('/creditnote/detail/{id}', ['uses' => 'Sales\creditnoteController@delete']);

Route::get('/api/listCreditNote', function() {

    $query = DB::table('vcreditnote');

    if (Auth::user()->role_id != 1 && Auth::user()->role_id != 5) {
        $query->where("responsible_id", Auth::user()->id);
    }

    return Datatables::queryBuilder($query)->make(true);
});
Route::get('/api/listCreditNotePDF', 'Sales\creditnoteController@editCreditNotePDF');

Route::get('/api/CreditNoteGenerated', function() {

    $query = DB::table('vcreditnote');

    if (Auth::user()->role_id != 1 && Auth::user()->role_id != 5) {
        $query->where("responsible_id", Auth::user()->id);
    }

    return Datatables::queryBuilder($query)->make(true);
});

Route::get('/creditnote/{id}/getInvoice', ['uses' => 'Sales\creditnoteController@getInvoice']);

Route::get('/api/listCategory', function() {
    return Datatables::queryBuilder(DB::table("vcategories")->orderBy("order", "asc"))->make(true);
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

Route::get('/api/listSupplier', function() {

    $query = DB::table('vsupplier');
    if (Auth::user()->role_id != 1 && Auth::user()->role_id != 5) {
        $query->where("responsible_id", Auth::user()->id);
    }
    return Datatables::queryBuilder($query)->make(true);
});

Route::get('/api/listClient', function() {

    $query = DB::table('vclient');

//    if (Auth::user()->role_id != 1) {
//        $query->where("responsible_id", Auth::user()->id);
//    }
    return Datatables::queryBuilder($query)->make(true);
});

Route::get('/api/listProduct', 'Administration\ProductController@listProduct');

Route::get('/api/listServices', function() {
    $query = DB::table('vservices');
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



Route::get('/api/listContact', 'Clients\ClientController@getContact');

Route::get('/api/listPurchase', function() {

    $query = DB::table("vpurchases");

    if (Auth::user()->role_id != 1 && Auth::user()->role_id == 5) {
        $query->where("warehouse_id", Auth::user()->warehouse_id);
    }

    return Datatables::queryBuilder($query)->make(true);
});

Route::get('/api/listSale', function() {

    $sql = DB::table('sales')
            ->select("sales.id", DB::raw("coalesce(sales.description,'') as description"), "sales.created", "departures.id as departure", "warehouses.description as warehouse")
            ->join("departures", "departures.id", "sales.departure_id")
            ->join("warehouses", "warehouses.id", "sales.warehouse_id");

    return Datatables::queryBuilder($sql)->make(true);
});
Route::get('/api/listEntry', function() {

    $query = DB::table("vpurchases");

    if (Auth::user()->role_id != 1 && Auth::user()->role_id == 5) {
        $query->where("warehouse_id", Auth::user()->warehouse_id);
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
    return Datatables::queryBuilder(DB::table("vusers"))->make(true);
});

Route::get('/api/listPuc', function() {
    return Datatables::eloquent(Models\Administration\Puc::query())->make(true);
});


Route::get('/api/listSpecial', 'Clients\ClientController@getSpecial');
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
Route::get('/api/getWarehouseProduct', 'Administration\SeekController@getWarehouseProduct');
Route::get('/api/getResponsable', 'Administration\SeekController@getResponsable');
Route::get('/api/getProduct', 'Administration\SeekController@getProduct');
Route::get('/api/getProductTransfer', 'Administration\SeekController@getProductTransfer');
Route::get('/api/getService', 'Administration\SeekController@getServices');
Route::get('/api/getCategory', 'Administration\SeekController@getCategory');
Route::get('/api/getNotification', 'Administration\SeekController@getNotification');
Route::get('/api/getCommercial', 'Administration\SeekController@getCommercial');
Route::get('/api/getBranch', 'Administration\SeekController@getBranch');
Route::get('/api/getAccount', 'Administration\SeekController@getAccount');
Route::get('api/getStatus', "Administration\SeekController@getStatus");

Route::get('/report/sale/{init}/{end}', 'Report\SalesController@getTotalSales');
Route::get('/report/fulfillmentSup/{init}/{end}', 'Report\SalesController@getFulfillmentSup');
Route::get('/report/fulfillmentCli/{init}/{end}', 'Report\SalesController@getFulfillmentCli');

Route::get('/briefcase', 'Sales\BriefcaseController@index');
Route::get('/briefcase/getInvoices', "Sales\BriefcaseController@getList");
Route::post('/briefcase/uploadSupport', "Sales\BriefcaseController@storePayment");
Route::get('/briefcase/getBriefcase', "Sales\BriefcaseController@getBriefcase");
Route::get('/briefcase/{id}/edit', "Sales\BriefcaseController@edit");
Route::delete('/briefcase/{id}', "Sales\BriefcaseController@delete");
Route::put('/briefcase/payInvoice/{id}', "Sales\BriefcaseController@payInvoice");
Route::get('/briefcase/testnotificaction/{id}/{commercial}', "Sales\BriefcaseController@testNotification");
Route::get('/briefcase/testPaidout/{id}', "Sales\BriefcaseController@testPaidout");

Route::get('api/productByClient', "Report\ClientController@getProductClient");


require __DIR__ . '/sales/orders.php';
require __DIR__ . '/sales/samples.php';
require __DIR__ . '/inventory/stock.php';
require __DIR__ . '/report/report.php';
require __DIR__ . '/report/samples.php';



require __DIR__ . '/cron.php';
require __DIR__ . '/ecommerce.php';
require __DIR__ . '/blog.php';
require __DIR__ . '/tool.php';
require __DIR__ . '/chat.php';
require __DIR__ . '/crm.php';
require __DIR__ . '/page.php';
require __DIR__ . '/security.php';
