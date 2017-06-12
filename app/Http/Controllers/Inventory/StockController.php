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

    public function index() {
        $warehouse = Warehouses::all();
        return view("Inventory.stock.init", compact("warehouse"));
    }

    public function getStock(Request $req) {
        $in = $req->all();
        $warehouse_entry = '';
        $warehouse_departure = '';
        if ($in["warehouse_id"] != 0) {
            $warehouse_entry = ' AND entries.warehouse_id=' . $in["warehouse_id"];
            $warehouse_departure = ' AND sales.warehouse_id=' . $in["warehouse_id"];
        }
        $bar_code = '';
        if ($in["bar_code"] != '') {
            $bar_code = " WHERE products.bar_code='" . $in["bar_code"] . "'";
        }

        $sql = "
            select products.id,products.reference,products.title as product,sum(entries_detail.quantity) entry,
            coalesce((
                    select sum(quantity) 
                    from sales_detail 
                    JOIN sales ON sales.id=sales_detail.sale_id 
                    where product_id=products.id and product_id IS NOT NULL " . $warehouse_departure . "),0) departure,
            sum(entries_detail.quantity) - coalesce((
                                                    select sum(quantity) 
                                                    from sales_detail 
                                                    JOIN sales ON sales.id=sales_detail.sale_id 
                                                    where product_id=products.id 
                                                    and product_id IS NOT NULL " . $warehouse_departure . "),0) total
            from products
            JOIN entries_detail ON entries_detail.product_id=products.id
            JOIN entries ON entries.id = entries_detail.entry_id and entries.status_id=2 " . $warehouse_entry . "
                $bar_code
            group by 1
            order by 6 desc";
//        echo $sql;exit;
        $resp = DB::select($sql);

        return response()->json(["data" => $resp]);
    }

    public function getDetailProduct(Request $req, $id) {
        $in = $req->all();

        $special = PricesSpecial::where("product_id", $id)->where("client_id", $in["client_id"])->first();

        if ($special != null) {
            $response = DB::table("products")
                    ->select("products.id", "products.title", "categories.description as caterory", "categories.id as category_id", "prices_special.price_sf", "products.cost_sf", "products.units_sf", "products.units_supplier")
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

    public function getDetailProductIn($client_id, $id) {

        $special = PricesSpecial::where("product_id", $id)->where("client_id", $client_id)->first();

        if ($special != null) {
            $response = DB::table("products")
                    ->select("products.id", "products.title", "categories.description as caterory", "categories.id as category_id", "prices_special.price_sf", "products.cost_sf", "products.units_sf", "products.units_supplier")
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
