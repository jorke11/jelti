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
use App\Models\Administration\Stakeholder;
use App\Models\Administration\Parameters;
use App\models\Administration\Consecutives;
use App\Models\Invoicing\Sales;
use Session;
use Illuminate\Support\Facades\Auth;

class DepartureController extends Controller {

    protected $total;

    public function __construct() {
        $this->middleware("auth");
        $this->total = 0;
    }

    public function index() {
        $category = \App\Models\Administration\Categories::all();
        $status = Parameters::where("group", "entry")->get();
        return view("Inventory.departure.init", compact("category", "status"));
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

    public function pdf($id) {
        $data = [
            'foo' => 'bar'
        ];
        $pdf = PDF::loadView('departure.pdf', $data);
        return $pdf->stream('document.pdf');
    }

    public function getInvoiceHtml($id) {
        $sale = Sales::where("departure_id", $id)->first();
        $detail = SaleDetail::select("quantity,tax,description,product_id,products.title product")
                ->join("products", "Sales.product_id", "products_id")
                ->where("sale_id", $sale["id"])
                ->get();
        $cli = Stakeholder::findOrFail($sale["client_id"]);
        $data = [
            'client' => $cli,
            'detail' => $detail,
        ];

        dd($detail);
        exit;

        return view("departure.pdf", compact("data"));
    }

    public function getInvoice($id) {
        $sale = Sales::where("departure_id", $id)->first();
        $detail = DB::table("sales_detail")
                ->select("quantity", "sales_detail.tax", "sales_detail.description", "products.title as product", "products.id as product_id", "sales_detail.value")
                ->join("products", "sales_detail.product_id", "products.id")
                ->where("sale_id", $sale["id"])
                ->orderBy("order", "asc")
                ->get();



        $cli = Stakeholder::findOrFail($sale["client_id"]);
        $data = [
            'client' => $cli,
            'detail' => $detail,
        ];
        $pdf = \PDF::loadView('Inventory.departure.pdf', [], $data, [
                    'title' => 'Invoice']);

        return $pdf->stream('document.pdf');
    }

    public function getQuantity($id) {
        $product = \App\Models\Invoicing\PurchaseDetail::where("product_id", $id)->first();
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
                $resp = Departures::FindOrFail($result["attributes"]["id"]);
                return response()->json(['success' => true, "data" => $resp]);
            } else {
                return response()->json(['success' => false]);
            }
        }
    }

    public function setSale(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            $basetax = Parameters::where("group", "tax")->where("code", 2)->first();
            $tax = Parameters::where("group", "tax")->where("code", 1)->first();
            $departure = Departures::findOrFail($input["id"]);

            $dep = Sales::where("departure_id", $input["id"])->get();

            if (count($dep) == 0) {
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
                        "account_id" => 1, "order" => $cont, "type_nature" => 1
                    ]);

                    $credit += (double) $totalPar;
                    if ($pro["tax"] != '' && $pro["tax"] > 0) {
                        $cont++;
                        $tax = (( $value->value * $value->quantity) * ($pro["tax"] / 100.0));
                        SaleDetail::insert([
                            "account_id" => 1, "sale_id" => $id, "value" => $tax,
                            "order" => $cont, "description" => 'iva', "type_nature" => 1
                        ]);
                    }
                    $credit += (double) $tax;
                    $cont++;
                }


                if ($total > $basetax["base"]) {
                    $rete = ($total * $tax["base"]);
                    SaleDetail::insert([
                        "sale_id" => $id, "account_id" => 2, "value" => ($total * $tax["base"]), "order" => $cont, "description" => "rete", "type_nature" => 2
                    ]);
                    $credit -= $rete;
                    $cont++;
                }

                SaleDetail::insert([
                    "account_id" => 2, "sale_id" => $id, "value" => $credit, "order" => $cont, "description" => "Clientes", "type_nature" => 2
                ]);
                $credit = 0;

                $departure->invoice = $this->createConsecutive(1);
                $departure->status_id = 2;
                $departure->save();
                $this->updateConsecutive(1);

                return response()->json(["success" => true, "data" => $departure]);
            } else {
                return response()->json(["success" => false, "msg" => 'Already sended']);
            }
        }
    }

    public function createConsecutive($id) {
        $con = Consecutives::where("type_form", $id)->first();

        $con->current = ($con->current == null) ? 1 : $con->current;
        $res = "";
        $con->pronoun = ($con->pronoun == null) ? '' : $con->pronoun;
        for ($i = strlen($con->pronoun); $i <= ($con->large - strlen($con->current)); $i++) {
            $res .= '0';
        }
        return $con->pronoun . $res . $con->current;
    }

    public function updateConsecutive($id) {
        $con = Consecutives::where("type_form", $id)->first();
        $con->current = (($con->current == null) ? 1 : $con->current) + 1;
        $con->save();
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
        $detail = $this->formatDetail(DB::table("departures_detail")->where("departure_id", $id)->get());

        return response()->json(["header" => $entry, "detail" => $detail]);
    }

    public function formatDetail($detail) {
        $this->total = 0;
        foreach ($detail as $i => $value) {
            $detail[$i]->valueFormated = "$ " . number_format($value->value, 2, ",", ".");
            $detail[$i]->total = $detail[$i]->quantity * $detail[$i]->value;
            $detail[$i]->totalFormated = "$ " . number_format($detail[$i]->total, 2, ",", ".");
            $this->total += $detail[$i]->total;
        }
        return $detail;
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
            return response()->json(['success' => true, "data" => $resp]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function updateDetail(Request $request, $id) {
        $entry = DeparturesDetail::FindOrFail($id);
        $input = $request->all();
        $result = $entry->fill($input)->save();
        if ($result) {
            $resp = DB::table("departures_detail")->where("departure_id", "=", $input["departure_id"])->get();
            return response()->json(['success' => true, "data" => $resp]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function destroy($id) {
        $entry = Departures::FindOrFail($id);
        $result = $entry->delete();
        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function destroyDetail($id) {
        $entry = DeparturesDetail::FindOrFail($id);
        $result = $entry->delete();
        if ($result) {
            $resp = DB::table("departures_detail")->where("departure_id", "=", $entry["departure_id"])->get();
            return response()->json(['success' => true, "data" => $resp]);
        } else {
            return response()->json(['success' => false]);
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
                $resp = DeparturesDetail::where("departure_id", $input["departure_id"])->get();
                $resp = $this->formatDetail($resp);
                return response()->json(['success' => true, "data" => $resp]);
            } else {
                return response()->json(['success' => false]);
            }
        }
    }

}
