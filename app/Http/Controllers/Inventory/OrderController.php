<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Inventory\Orders;
use App\Models\Inventory\OrdersDetail;
use Session;

class OrderController extends Controller {

    public function __construct() {
        $this->middleware("auth");
    }

    public function index() {
        $responsable = DB::select('select id,name from users');
        $warehouse = \App\Models\Administration\Warehouses::all();
        $product = \App\Models\Administration\Products::all();
        $mark = \App\Models\Administration\Mark::all();
        $supplier = \App\Models\Administration\Suppliers::all();
        $category = \App\Models\Administration\Categories::all();
        return view("order.init", compact("responsable", "warehouse", "supplier", "product", "mark", "category"));
    }

    public function getConsecutive($id) {
        echo response()->json(["response" => 'prueba']);
    }

    public function getDetailProduct($id) {
        $response = DB::table("products")
                ->select("products.id", "products.title", "categories.description as caterory", "products.price_sf")
                ->join("categories", "categories.id", "=", "products.id")
                ->where("products.id", $id)
                ->first();
        $entry = DB::table("entries_detail")->where("product_id", $id)->sum("quantity");
        $order = DB::table("orders_detail")->where("product_id", $id)->sum("quantity");
        $quantity = $entry - $order;

        return response()->json(["response" => $response, "quantity" => $quantity]);
    }

    public function getQuantity($id) {
        $product = \App\Models\Invoicing\PurchasesDetail::where("product_id", $id)->first();
        return response()->json(["response" => $product]);
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);
//            $user = Auth::User();
            $input["status_id"] = 1;

            $result = Orders::create($input);
            if ($result) {
                Session::flash('save', 'Se ha creado correctamente');
                $resp = Orders::FindOrFail($result["attributes"]["id"]);
                return response()->json(['success' => 'true', "data" => $resp]);
            } else {
                return response()->json(['success' => 'false']);
            }
        }
    }

    public function edit($id) {
        $entry = Orders::FindOrFail($id);
        $detail = DB::table("orders_detail")->where("order_id", "=", $id)->get();
        return response()->json(["header" => $entry, "detail" => $detail]);
    }

    public function getDetail($id) {
        $detail = OrdersDetail::FindOrFail($id);
        return response()->json($detail);
    }

    public function update(Request $request, $id) {
        $entry = Orders::FindOrFail($id);
        $input = $request->all();
        $result = $entry->fill($input)->save();
        if ($result) {
            $resp = Orders::FindOrFail($id);
            Session::flash('save', 'Se ha creado correctamente');
            return response()->json(['success' => 'true', "data" => $resp]);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

    public function getClient($id) {
        $supplier = \App\Models\Administration\Suppliers::findOrFail($id);
        return response()->json(["response" => $supplier]);
    }

    public function updateDetail(Request $request, $id) {
        $entry = OrdersDetail::FindOrFail($id);
        $input = $request->all();
        $result = $entry->fill($input)->save();
        if ($result) {
            $resp = DB::table("orders_detail")->where("order_id", "=", $input["order_id"])->get();
            Session::flash('save', 'Se ha creado correctamente');
            return response()->json(['success' => 'true', "data" => $resp]);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

    public function destroy($id) {
        $entry = Orders::FindOrFail($id);
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
        $entry = OrdersDetail::FindOrFail($id);
        $result = $entry->delete();
        Session::flash('delete', 'Se ha eliminado correctamente');
        if ($result) {
            $resp = DB::table("ordersº_detail")->where("order_id", "=", $entry["order_id"])->get();
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
            $input["status_id"] = 1;
            $input["pending"] = $input["quantity"];
            $result = OrdersDetail::create($input);
            if ($result) {
                Session::flash('save', 'Se ha creado correctamente');
                $resp = OrdersDetail::where("order_id", $input["order_id"])->get();
                return response()->json(['success' => 'true', "data" => $resp]);
            } else {
                return response()->json(['success' => 'false']);
            }
        }
    }

}
