<?php

namespace App\Http\Controllers\Invoicing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Invoicing\Sales;
use App\Models\Invoicing\SaleDetail;
use \Illuminate\Support\Facades\DB;
use Session;

class SaleController extends Controller {

    public function index() {
        $category = \App\Models\Administration\Categories::all();
        return view("sale.init", compact("category"));
    }

    public function getConsecutive($id) {
        echo response()->json(["response" => 'prueba']);
    }

    public function getQuantity($id) {
        $product = \App\Models\Invoicing\PurchageDetail::where("product_id", $id)->first();
        return response()->json(["response" => $product]);
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);
            $result = Sales::create($input);
            if ($result) {
                $resp = Sales::FindOrFail($result["attributes"]["id"]);
                return response()->json(['success' => 'true', "data" => $resp]);
            } else {
                return response()->json(['success' => 'false']);
            }
        }
    }

    public function edit($id) {
        $entry = Sales::FindOrFail($id);
        $detail = DB::table("sales_detail")->where("sale_id", "=", $id)->orderBy("order", "asc")->get();
        return response()->json(["header" => $entry, "detail" => $detail]);
    }

    public function getDetail($id) {
        $detail = SaleDetail::FindOrFail($id);
        return response()->json($detail);
    }

    public function getDetailProduct($id) {
        $response = DB::table("products")
                ->select("products.id", "products.title", "categories.description as caterory", "categories.id as category_id", "products.price_sf")
                ->join("categories", "categories.id", "=", "products.category_id")
                ->where("products.id", $id)
                ->first();
        $entry = DB::table("entries_detail")->where("product_id", $id)->sum("quantity");
        $departure = DB::table("departures_detail")->where("product_id", $id)->sum("quantity");
        $quantity = $entry - $departure;

        return response()->json(["response" => $response, "quantity" => $quantity]);
    }

    public function update(Request $request, $id) {
        $entry = Sale::FindOrFail($id);
        $input = $request->all();
        $result = $entry->fill($input)->save();
        if ($result) {
            $resp = Sale::FindOrFail($id);
            Session::flash('save', 'Se ha creado correctamente');
            return response()->json(['success' => 'true', "data" => $resp]);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

    public function updateDetail(Request $request, $id) {
        $entry = SaleDetail::FindOrFail($id);
        $input = $request->all();
        $result = $entry->fill($input)->save();
        if ($result) {
            $resp = DB::table("saledetail")->where("sale_id", "=", $input["sale_id"])->get();
            Session::flash('save', 'Se ha creado correctamente');
            return response()->json(['success' => 'true', "data" => $resp]);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

    public function destroy($id) {
        $entry = Sale::FindOrFail($id);
        $result = $entry->delete();
        Session::flash('delete', 'Se ha eliminado correctamente');
        if ($result) {
            Session::flash('save', 'Se ha creado correctamente');
            return response()->json(['success' => 'true']);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

    public function destroyDetail($id) {
        $entry = SaleDetail::FindOrFail($id);
        $result = $entry->delete();
        Session::flash('delete', 'Se ha eliminado correctamente');
        if ($result) {
            $resp = DB::table("saledetail")->where("sale_id", "=", $entry["sale_id"])->get();
            Session::flash('save', 'Se ha creado correctamente');
            return response()->json(['success' => 'true', "data" => $resp]);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

    public function storeDetail(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);
//            $user = Auth::User();
//            $input["users_id"] = 1;
            $input["account_id"] = 1;
            $input["order"] = 1;
            $result = SaleDetail::create($input);
            if ($result) {
                Session::flash('save', 'Se ha creado correctamente');
                $resp = SaleDetail::where("sale_id", $input["sale_id"])->get();
                return response()->json(['success' => 'true', "data" => $resp]);
            } else {
                return response()->json(['success' => 'false']);
            }
        }
    }

}
