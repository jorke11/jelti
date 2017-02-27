<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Inventory\Departure;
use App\Models\Inventory\Order;
use App\Models\Inventory\DepartureDetail;
use App\Models\Inventory\OrderDetail;
use Session;

class DepartureController extends Controller {

    public function index() {

        $responsable = DB::select('select id,name from users');
        $warehouse = \App\Models\Administration\Warehouse::all();
        $product = \App\Models\Administration\Product::all();
        $mark = \App\Models\Administration\Mark::all();
        $supplier = \App\Models\Administration\Supplier::all();
        $category = \App\Models\Administration\Category::all();
        return view("departure.init", compact("responsable", "warehouse", "supplier", "product", "mark", "category"));
    }

    public function showOrder($id) {
        return view("departure.init", compact("id"));
    }

    public function getOrderExt($id) {
        $entry =Order::findOrFail($id);
        $detail = DB::select("SELECT id,product_id,quantity-pending as quantity,value FROM order_detail where order_id=" . $id);

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
        $departure = DB::table("departure_detail")->where("product_id", $id)->sum("quantity");
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
            unset($input["id"]);
//            $user = Auth::User();
            $input["status_id"] = 1;

            $result = Departure::create($input);
            if ($result) {
                Session::flash('save', 'Se ha creado correctamente');
                $resp = Departure::FindOrFail($result["attributes"]["id"]);
                return response()->json(['success' => 'true', "data" => $resp]);
            } else {
                return response()->json(['success' => 'false']);
            }
        }
    }

    public function storeExtern(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            $order = Order::findOrFail($input["id"]);

            dd($order);
            exit;

            $id = DB::table("departure")->insertGetId(
                    ["order_id" => $input["id"], "warehouse_id" => $order["warehouse_id"], "responsable_id" => $order["responsable_id"],
                        "client_id" => $order["client_id"], "city_id" => $order["city_id"], "destination_id" => $order["destination_id"],
                        "status_id" => $order["status_id"], "created" => $order["created"], "address" => $order["address"], "phone" => $order["phone"],
                        "branch_id" => $order["branch_id"],
                    ]
            );


            $detail = DB::select("SELECT id,product_id,quantity-pending as quantity,value FROM order_detail where order_id=" . $input["id"]);

            dd($detail);
            exit;
        }
    }

    public function edit($id) {
        $entry = Departure::FindOrFail($id);
        $detail = DB::table("departure_detail")->where("departure_id", "=", $id)->get();
        return response()->json(["header" => $entry, "detail" => $detail]);
    }

    public function getDetail($id) {
        $detail = DepartureDetail::FindOrFail($id);
        return response()->json($detail);
    }

    public function update(Request $request, $id) {
        $entry = Departure::FindOrFail($id);
        $input = $request->all();
        $result = $entry->fill($input)->save();
        if ($result) {
            $resp = Departure::FindOrFail($id);
            Session::flash('save', 'Se ha creado correctamente');
            return response()->json(['success' => 'true', "data" => $resp]);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

    public function updateDetail(Request $request, $id) {
        $entry = DepartureDetail::FindOrFail($id);
        $input = $request->all();
        $result = $entry->fill($input)->save();
        if ($result) {
            $resp = DB::table("departure_detail")->where("departure_id", "=", $input["departure_id"])->get();
            Session::flash('save', 'Se ha creado correctamente');
            return response()->json(['success' => 'true', "data" => $resp]);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

    public function destroy($id) {
        $entry = Departure::FindOrFail($id);
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
        $entry = DepartureDetail::FindOrFail($id);
        $result = $entry->delete();
        Session::flash('delete', 'Se ha eliminado correctamente');
        if ($result) {
            $resp = DB::table("departure_detail")->where("departure_id", "=", $entry["departure_id"])->get();
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
            $result = DepartureDetail::create($input);
            if ($result) {
                Session::flash('save', 'Se ha creado correctamente');
                $resp = DepartureDetail::where("departure_id", $input["departure_id"])->get();
                return response()->json(['success' => 'true', "data" => $resp]);
            } else {
                return response()->json(['success' => 'false']);
            }
        }
    }

}
