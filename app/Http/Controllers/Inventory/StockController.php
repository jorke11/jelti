<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Dompdf\Adapter\PDFLib;
use App\Models\Administration\Products;
use App\Models\Administration\PricesSpecial;
use Datatables;
use PDF;
use App\Models\Administration\Warehouses;

class StockController extends Controller {

    public function __construct() {
        $this->middleware("auth");
    }

    public function index() {
        $warehouse = Warehouses::all();
        return view("Inventory.stock.init", compact("warehouse"));
    }

    public function getStock(Request $req) {
        $in = $req->all();
        $entry_ware = '';
        $sales_ware = '';
        if ($in["warehouse_id"] != 0) {
            $entry_ware = ' AND entries.warehouse_id=' . $in["warehouse_id"];
            $sales_ware = ' AND sales.warehouse_id=' . $in["warehouse_id"];
        }
        $bar_code = '';


        if ($in["bar_code"] != '') {
            $pro = Products::where("bar_code", $in["bar_code"])->first();
            $bar_code = "WHERE id=" . $pro->id;
        }


        $sql = "
            select id,reference,title as product
            from products $bar_code";
        $products = DB::select($sql);
        foreach ($products as $i => $value) {
            $sql = "
                    select coalesce(sum(quantity),0) as total
                    from entries_detail
                    JOIN entries ON entries.id=entries_detail.entry_id 
                    WHERE entries.status_id=2 and product_id=" . $value->id . " $entry_ware";
            $entry = DB::select($sql);

            $sql = "
                    select coalesce(sum(quantity),0) as total
                    from sales_detail
                    JOIN sales ON sales.id=sales_detail.sale_id
                    WHERE product_id=" . $value->id . " $sales_ware";
            $sale = DB::select($sql);

            $products[$i]->entries = $entry[0]->total;
            $products[$i]->sales = $sale[0]->total;
            $products[$i]->available = $products[$i]->entries - $products[$i]->sales;
        }

        return response()->json(["data" => $products]);
    }

    public function getDetailProduct(Request $req, $id) {
        $in = $req->all();
        $special = null;
        if (isset($in["client_id"]) && $in["client_id"] != '') {
            $special = PricesSpecial::where("product_id", $id)->where("client_id", $in["client_id"])->first();
        }


        if ($special) {

            $response = DB::table("products")
                            ->select("products.id", "products.title", "products.tax", "categories.description as caterory", "categories.id as category_id", "prices_special.price_sf", "products.cost_sf", "products.units_sf", "products.units_supplier")
                            ->join("categories", "categories.id", "=", "products.category_id")
                            ->join("prices_special", "prices_special.product_id", "=", "products.id")
                            ->where("products.id", $id)
                            ->where("prices_special.client_id", $in["client_id"])->first();
        } else {
            $response = DB::table("products")
                    ->select("products.id", "products.title", "products.tax", "categories.description as caterory", "categories.id as category_id", "products.price_sf", "products.cost_sf", "products.units_sf", "products.units_supplier", "products.margin_sf", "products.packaging")
                    ->leftjoin("categories", "categories.id", "=", "products.category_id")
                    ->where("products.id", $id)
                    ->first();
        }


        $entry = DB::table("entries_detail")->where("product_id", $id)->where("status_id", 3)->sum(DB::raw("quantity * units_supplier"));
        $departure = DB::table("departures_detail")->where("product_id", $id)->where("status_id", 3)->sum("quantity");
        $purchase = DB::table("purchases_detail")->where("product_id", $id)->sum("quantity");
        $sales = DB::table("sales_detail")->where("product_id", $id)->whereNotNull("product_id")->sum("quantity");
        $quantity = $entry - $sales;

        return response()->json(["response" => $response, "quantity" => $quantity]);
    }

    public function getDetailSample(Request $req, $id) {
        $in = $req->all();
        $special = null;
//        if (isset($in["client_id"]) && $in["client_id"] != '') {
//            $special = PricesSpecial::where("product_id", $id)->where("client_id", $in["client_id"])->first();
//        }
//        if ($special) {
//            $response = DB::table("products")
//                            ->select("products.id", "products.title", "products.tax", "categories.description as caterory", "categories.id as category_id", "prices_special.price_sf", "products.cost_sf", "products.units_sf", "products.units_supplier")
//                            ->join("categories", "categories.id", "=", "products.category_id")
//                            ->join("prices_special", "prices_special.product_id", "=", "products.id")
//                            ->where("products.id", $id)
//                            ->where("prices_special.client_id", $in["client_id"])->first();
//        } else {
        $response = DB::table("products")
                ->select("products.id", "products.title", "products.tax", "categories.description as caterory", "categories.id as category_id", "products.price_sf", "products.cost_sf", "products.units_sf", "products.units_supplier", "products.margin_sf", "products.packaging")
                ->leftjoin("categories", "categories.id", "=", "products.category_id")
                ->where("products.id", $id)
                ->first();
//        }


        $entry = DB::table("entries_detail")->where("product_id", $id)->where("status_id", 3)->sum(DB::raw("quantity * units_supplier"));
        $departure = DB::table("departures_detail")->where("product_id", $id)->where("status_id", 3)->sum("quantity");
        $purchase = DB::table("purchases_detail")->where("product_id", $id)->sum("quantity");
        $sales = DB::table("sales_detail")->where("product_id", $id)->whereNotNull("product_id")->sum("quantity");
        $quantity = $entry - $sales;

        return response()->json(["response" => $response, "quantity" => $quantity]);
    }

    public function getDetailProductOut($id) {

//        dd($id);
        $response = DB::table("products")
                ->select("products.id", "products.title", "products.tax", "categories.description as caterory", "categories.id as category_id", "products.price_sf", "products.cost_sf", "products.units_sf", "products.units_supplier")
                ->join("categories", "categories.id", "=", "products.category_id")
                ->where("products.id", $id)
                ->first();

        $entry = DB::table("entries_detail")->where("product_id", $id)->where("status_id", 3)->sum(DB::raw("quantity * units_supplier"));
        $departure = DB::table("departures_detail")->where("product_id", $id)->where("status_id", 3)->sum("quantity");
        $purchase = DB::table("purchases_detail")->where("product_id", $id)->sum("quantity");
        $sales = DB::table("sales_detail")->where("product_id", $id)->whereNotNull("product_id")->sum("quantity");
        $quantity = $entry - $sales;

        return response()->json(["response" => $response, "quantity" => $quantity]);
    }

    public function getDetailProductIn($client_id, $id) {
        $special = PricesSpecial::where("product_id", $id)->where("client_id", $client_id)->first();

        if ($special != null) {
            $response = DB::table("products")
                    ->select("products.id", "products.title", "products.tax", "categories.description as caterory", "categories.id as category_id", "prices_special.price_sf", "products.cost_sf", "products.units_sf", "products.units_supplier")
                    ->join("categories", "categories.id", "=", "products.category_id")
                    ->join("prices_special", "prices_special.product_id", "=", "products.id")
                    ->where("products.id", $id)
                    ->first();
        } else {
            $response = DB::table("products")
                    ->select("products.id", "products.title", "categories.description as caterory", "categories.id as category_id", "products.price_sf", "products.cost_sf", "products.units_sf", "products.units_supplier")
                    ->join("categories", "categories.id", "=", "products.category_id")
                    ->where("products.id", $id)
                    ->first();
        }

        $entry = DB::table("entries_detail")->where("product_id", $id)->where("status_id", 3)->sum(DB::raw("quantity * units_supplier"));
        $departure = DB::table("departures_detail")->where("product_id", $id)->where("status_id", 3)->sum("quantity");
        $purchase = DB::table("purchases_detail")->where("product_id", $id)->sum("quantity");
        $sales = DB::table("sales_detail")->where("product_id", $id)->whereNotNull("product_id")->sum("quantity");
        $quantity = $entry - $sales;

        return response()->json(["response" => $response, "quantity" => $quantity]);
    }

}
