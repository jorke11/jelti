<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Dompdf\Adapter\PDFLib;
use Datatables;
use PDF;

class StockController extends Controller {

    public function index() {
        return view("Inventory.stock.init");
    }

    public function getStock() {
        return Datatables::queryBuilder(DB::table("vstock"))->make(true);
    }

    public function getDetailProduct($id) {
        $response = DB::table("products")
                ->select("products.id", "products.title", "categories.description as caterory", "categories.id as category_id", "products.price_sf")
                ->join("categories", "categories.id", "=", "products.category_id")
                ->where("products.id", $id)
                ->first();
        $entry = DB::table("entries_detail")->where("product_id", $id)->sum("quantity");
        $departure = DB::table("departures_detail")->where("product_id", $id)->sum("quantity");
        $purchase = DB::table("purchases_detail")->where("product_id", $id)->sum("quantity");
        $quantity = ($entry + $purchase) - $departure;

        return response()->json(["response" => $response, "quantity" => $quantity]);
    }

}
