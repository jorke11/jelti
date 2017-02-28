<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Inventory\Departures;
use App\Models\Inventory\Orders;
use App\Models\Inventory\DeparturesDetail;
use App\Models\Inventory\OrdersDetail;
use App\Models\Invoicing\PurchasesDetail;
use Session;

class DepartureController extends Controller {

    public function index() {

        $responsable = DB::select('select id,name from users');
        $warehouse = \App\Models\Administration\Warehouses::all();
        $product = \App\Models\Administration\Products::all();
        $mark = \App\Models\Administration\Mark::all();
        $supplier = \App\Models\Administration\Suppliers::all();
        $category = \App\Models\Administration\Categories::all();
        return view("departure.init", compact("responsable", "warehouse", "supplier", "product", "mark", "category"));
    }

    public function showOrder($id) {
        return view("departure.init", compact("id"));
    }

    public function getOrderExt($id) {
        $entry = Orders::findOrFail($id);
        $detail = DB::select("SELECT id,product_id,quantity-pending as quantity,value FROM orders_detail where order_id=" . $id);

        return response()->json(["header" => $entry, "detail" => $detail]);
    }

    public function getConsecutive($id) {
        echo response()->json(["response" => 'prueba']);
    }

    public function getDetailProduct($id) {
        $response = DB::table("product")
                ->select("product.id", "product.title", "category.description as caterory", "product.price_sf")
                ->join("category", "category.id", "=", "product.category_id")
                ->where("product.id", $id)
                ->first();
        $entry = DB::table("entry_detail")->where("product_id", $id)->sum("quantity");
        $departure = DB::table("departures_detail")->where("product_id", $id)->sum("quantity");
        $quantity = $entry - $departure;

        return response()->json(["response" => $response, "quantity" => $quantity]);
    }

    public function getQuantity($id) {
        $product = \App\Models\Invoicing\PurchageDetail::where("product_id", $id)->first();
        return response()->json(["response" => $product]);
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["departure_id"]);
//            $user = Auth::User();
            $input["status_id"] = 1;

            $result = Departures::create($input);
            if ($result) {
                Session::flash('save', 'Se ha creado correctamente');
                $resp = Departures::FindOrFail($result["attributes"]["id"]);
                return response()->json(['success' => 'true', "data" => $resp]);
            } else {
                return response()->json(['success' => 'false']);
            }
        }
    }

    public function storeExtern(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            $order = Orders::findOrFail($input["id"]);

            $id = DB::table("departures")->insertGetId(
                    ["order_id" => $input["id"], "warehouse_id" => $order["warehouse_id"], "responsible_id" => $order["responsible_id"],
                        "client_id" => $order["client_id"], "city_id" => $order["city_id"], "destination_id" => $order["destination_id"],
                        "status_id" => $order["status_id"], "created" => $order["created"], "address" => $order["address"], "phone" => $order["phone"],
                        "branch_id" => $order["branch_id"],
                    ]
            );

            $detail = DB::select("SELECT id,product_id,quantity-pending as quantity,value,category_id FROM orders_detail where order_id=" . $input["id"]);

            foreach ($detail as $value) {
                DeparturesDetail::insert([
                    'departure_id' => $id, "value" => $value->value, "product_id" => $value->product_id, "category_id" => $value->category_id,
                    "quantity" => $value->quantity
                ]);
            }
        }
        $resp = Departures::FindOrFail($id);
        return response()->json(["success" => 'true', "data" => $resp]);
    }

    public function edit($id) {
        $entry = Departures::FindOrFail($id);
        $detail = DB::table("departures_detail")->where("id", "=", $id)->get();
        return response()->json(["header" => $entry, "detail" => $detail]);
    }

    public function getDetail($id) {
        $detail = DeparturesDetail::FindOrFail($id);
        return response()->json($detail);
    }

    public function update(Request $request, $id) {
        $entry = Departures::FindOrFail($id);
        $input = $request->all();
        $result = $entry->fill($input)->save();
        if ($result) {
            $resp = Departures::FindOrFail($id);
            Session::flash('save', 'Se ha creado correctamente');
            return response()->json(['success' => 'true', "data" => $resp]);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

    public function updateDetail(Request $request, $id) {
        $entry = DeparturesDetail::FindOrFail($id);
        $input = $request->all();
        $result = $entry->fill($input)->save();
        if ($result) {
            $resp = DB::table("departures_detail")->where("departure_id", "=", $input["departure_id"])->get();
            Session::flash('save', 'Se ha creado correctamente');
            return response()->json(['success' => 'true', "data" => $resp]);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

    public function destroy($id) {
        $entry = Departures::FindOrFail($id);
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
        $entry = DeparturesDetail::FindOrFail($id);
        $result = $entry->delete();
        Session::flash('delete', 'Se ha eliminado correctamente');
        if ($result) {
            $resp = DB::table("departures_detail")->where("departure_id", "=", $entry["departure_id"])->get();
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
            $result = DeparturesDetail::create($input);
            if ($result) {
                Session::flash('save', 'Se ha creado correctamente');
                $resp = DeparturesDetail::where("departure_id", $input["departure_id"])->get();
                return response()->json(['success' => 'true', "data" => $resp]);
            } else {
                return response()->json(['success' => 'false']);
            }
        }
    }

}
