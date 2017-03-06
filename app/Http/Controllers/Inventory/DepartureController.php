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
use App\Models\Invoicing\SaleDetail;
use App\Models\Administration\Products;
use Session;

class DepartureController extends Controller {

    public function index() {
        $category = \App\Models\Administration\Categories::all();
        return view("departure.init", compact("category"));
    }

    public function showOrder($id) {
        return view("departure.init", compact("id"));
    }

    public function getOrderExt($id) {
        $entry = Orders::findOrFail($id);
        $detail = DB::select("SELECT id,product_id,generate as quantity,value FROM orders_detail where order_id=" . $id);

        return response()->json(["header" => $entry, "detail" => $detail]);
    }

    public function getConsecutive($id) {
        echo response()->json(["response" => 'prueba']);
    }

    public function pdf() {
        $data = [
            'foo' => 'bar'
        ];
        $pdf = PDF::loadView('departure.pdf', $data);
        return $pdf->stream('document.pdf');
    }
    
    public function getInvoiceHtml(){
        $data = [
            'foo' => 'bar'
        ];
        
        return view("departure.pdf", compact("data"));
    }

    public function getInvoice() {
        $data = [
            'foo' => 'bar'
        ];
        $pdf = \PDF::loadView('departure.pdf', [], $data, [
                    'title' => 'Invoice']);

        return $pdf->stream('document.pdf');
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

    public function setSale(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();

            $departure = Departures::findOrFail($input["id"]);


            $id = DB::table("sales")->insertGetId(
                    ["departure_id" => $departure["id"], "warehouse_id" => $departure["warehouse_id"], "responsible_id" => $departure["responsible_id"],
                        "client_id" => $departure["client_id"], "city_id" => $departure["city_id"], "destination_id" => $departure["destination_id"],
                        "address" => $departure["address"], "phone" => $departure["phone"],
                        "status_id" => $departure["status_id"], "created" => $departure["created"]
                    ]
            );

            $detail = DeparturesDetail::where("departure_id", $input["id"])->get();

            $total = 0;
            $cont = 0;
            $credit = 0;
            $tax = 0;
            $totalPar = 0;
            foreach ($detail as $value) {
                $pro = Products::findOrFail($value->product_id);
                $totalPar = $value->quantity * $value->value;
                $total += $totalPar;
                SaleDetail::insert([
                    "sale_id" => $id, "product_id" => $value->product_id,
                    "category_id" => $value->category_id, "quantity" => $value->quantity,
                    "value" => $value->value, "tax" => $pro["tax"],
                    "account_id" => 1, "order" => $cont
                ]);

                $credit += (double) $totalPar;
                if ($pro["tax"] != '' && $pro["tax"] > 0) {
                    $cont++;
                    $tax = (( $value->value * $value->quantity) * ($pro["tax"] / 100.0));
                    SaleDetail::insert([
                        "account_id" => 1, "sale_id" => $id, "value" => $tax,
                        "order" => $cont, "description" => 'iva'
                    ]);
                }
                $credit += (double) $tax;
                $cont++;
            }


            if ($total > 860000) {
                $rete = ($total * 0.025);
                SaleDetail::insert([
                    "sale_id" => $id, "account_id" => 2, "value" => ($total * 0.025), "order" => $cont, "description" => "rete"
                ]);
                $credit -= $rete;
                $cont++;
            }

            SaleDetail::insert([
                "account_id" => 2, "sale_id" => $id, "value" => $credit, "order" => $cont, "description" => "Clientes"
            ]);
            $credit = 0;

            $departure->status_id = 2;
            $departure->save();
        }
        return response()->json(["success" => true]);
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

            $detail = DB::select("
                    SELECT id,product_id,pending-generate as quantity,generate,value,category_id 
                    FROM orders_detail 
                    WHERE status_id = 1 and order_id=" . $input["id"]);

            foreach ($detail as $value) {
                if ($value->quantity == 0) {
                    OrdersDetail::where("id", $value->id)->update(["status_id" => 2]);
                }


                DeparturesDetail::insert([
                    'departure_id' => $id, "value" => $value->value, "product_id" => $value->product_id, "category_id" => $value->category_id,
                    "quantity" => $value->generate
                ]);


                OrdersDetail::where("id", $value->id)->update(["generate" => $value->generate, "pending" => $value->quantity]);
            }
        }
        $resp = Departures::FindOrFail($id);
        $detail = DeparturesDetail::where("departure_id", $id)->get();

        return response()->json(["success" => true, "header" => $resp, "detail" => $detail]);
    }

    public function edit($id) {
        $entry = Departures::FindOrFail($id);
        $detail = DB::table("departures_detail")->where("departure_id", $id)->get();
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
