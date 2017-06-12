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


class StockController extends Controller {

    public function index() {
        return view("Inventory.stock.init");
    }

    public function getStock() {
        $sql = "
            select products.id,products.title,sum(entries_detail.quantity) entradas,
            coalesce((select sum(quantity) from sales_detail where product_id=products.id and product_id IS NOT NULL),0) salidas,
            sum(entries_detail.quantity) - coalesce((select sum(quantity) from sales_detail where product_id=products.id and product_id IS NOT NULL),0) total
            from products
            JOIN entries_detail ON entries_detail.product_id=products.id
            JOIN entries ON entries.id = entries_detail.entry_id and entries.status_id=2
            group by 1
            order by 5 desc";
        $resp = DB::select($sql);
        $stock = Products::select("products.id", "products.title", DB::raw("entries_detail.quantity"))->sum(DB::raw("entries_detail.quantity"))
                ->join("entries_detail", "entries_detail.product_id", "products.id")
                ->join("entries", "entries.id", DB::raw("entries_detail.entry_id and entries.status_id=2"))
                ->groupBy("products.id", "products.title")
                ->get();

        dd($stock);
        return Datatables::queryBuilder(DB::table("vstock"))->make(true);
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
