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
use App\Models\Administration\Branch;
use App\Models\Administration\Email;
use App\Models\Administration\EmailDetail;
use App\Models\Administration\Warehouses;
use App\Models\Administration\Cities;
use App\Models\Security\Users;
use App\Models\Invoicing\Sales;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Inventory\StockController;
use App\Http\Controllers\ToolController;
use Mail;
use Maatwebsite\Excel\Facades\Excel;

class DepartureController extends Controller {

    protected $total;
    public $total_real;
    public $path;
    public $name;
    public $listProducts;
    public $errors;

    public function __construct() {
        $this->middleware("auth");
        $this->total = 0;
        $this->total_real = 0;
        $this->path = '';
        $this->name = '';
        $this->listProducts = array();
        $this->errors = array();
    }

    public function index() {
        $category = \App\Models\Administration\Categories::all();
        $status = Parameters::where("group", "departure")->get();
        return view("Inventory.departure.init", compact("category", "status"));
    }

    public function showOrder($id) {
        return view("departure.init", compact("id"));
    }

    public function getClient($id) {
        $resp["client"] = Stakeholder::find($id);
        $resp["branch"] = Branch::where("stakeholder_id", $resp["client"]->id)->get();
        return response()->json(["success" => true, "data" => $resp]);
    }

    public function getBranch($id) {
        $response = Branch::find($id);
        return response()->json(["response" => $response]);
    }

    public function getOrderExt($id) {
        $entry = Orders::findOrFail($id);
        $detail = DB::select("SELECT id,product_id,generate as quantity,value FROM orders_detail where order_id=" . $id);

        return response()->json(["header" => $entry, "detail" => $detail]);
    }

    public function getConsecutive($id) {
        return response()->json(["response" => $this->createConsecutive(3)]);
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

    public function formatDate($date) {
        $month = date("m", strtotime($date));
        $monthtext = '';
        if ($month == '01')
            $monthtext = 'enero';
        if ($month == '02')
            $monthtext = 'febrero';
        if ($month == '03')
            $monthtext = 'marzo';
        if ($month == '04')
            $monthtext = 'abril';
        if ($month == '05')
            $monthtext = 'mayo';
        if ($month == '06')
            $monthtext = 'junio';
        if ($month == '07')
            $monthtext = 'julio';
        if ($month == '08')
            $monthtext = 'agosto';
        if ($month == '09')
            $monthtext = 'septiembre';
        if ($month == '10')
            $monthtext = 'octubre';
        if ($month == '11')
            $monthtext = 'noviembre';
        if ($month == '12')
            $monthtext = 'diciembre';


        return date("d", strtotime($date)) . " de " . ucwords($monthtext) . " de " . date("Y", strtotime($date));
    }

    public function getInvoice($id) {

        $sale = Sales::where("departure_id", $id)->first();
        $detail = DB::table("sales_detail")
                ->select("quantity", DB::raw("sales_detail.tax * 100 as tax"), DB::raw("coalesce(sales_detail.description,'') as description"), "products.title as product", "products.id as product_id", "sales_detail.value", "sales_detail.units_sf", DB::raw("sales_detail.units_sf * sales_detail.quantity as quantityTotal"), DB::raw("sales_detail.value * sales_detail.quantity * sales_detail.units_sf as valueTotal"), "stakeholder.business as stakeholder")
                ->join("products", "sales_detail.product_id", "products.id")
                ->join("stakeholder", "products.supplier_id", "stakeholder.id")
                ->where("sale_id", $sale["id"])
                ->orderBy("order", "asc")
                ->get();

        $dep = Departures::find($id);
        $cli = Branch::select("branch_office.id", "branch_office.business_name", "branch_office.document", "branch_office.address_invoice", "cities.description as city", "branch_office.term")
                ->where("stakeholder_id", $sale["client_id"])
                ->join("cities", "cities.id", "branch_office.city_id")
                ->first();
        $user = Users::find($sale["responsible_id"]);
        $term = 7;

        if ($cli["term"] != null) {
            $term = $cli["term"];
        }

        $expiration = date('Y-m-d', strtotime('+' . $term . ' days', strtotime($sale["created"])));


        $cli["emition"] = $this->formatDate($sale["created"]);
        $cli["expiration"] = $this->formatDate($expiration);
        $cli["responsible"] = ucwords($user->name . " " . $user->last_name);

        $totalExemp = 0;
        $totalTax5 = 0;
        $totalTax19 = 0;
        $tax = 0;
        $totalSum = 0;
        foreach ($detail as $value) {
            $totalSum += $value->valuetotal;
            $tax = ($value->tax / 100);

            if ($value->tax == 0) {
                $totalExemp += $value->valuetotal;
            }
            if ($value->tax == '5') {
                $totalTax5 += $value->valuetotal * $tax;
            }
            if ($value->tax == '19') {

                $totalTax19 += $value->valuetotal * $tax;
            }
        }

        $rete = SaleDetail::where("description", "rete")->where("sale_id", $sale["id"])->first();

//        $totalWithTax = $totalSum + $totalTax19 + $totalTax5 + $dep->shipping_cost - ($rete["value"]);
        $totalWithTax = $totalSum + $totalTax19 + $totalTax5 + $dep->shipping_cost;

        $tool = new ToolController();

        $cli["business_name"] = $tool->cleanText($cli["business_name"]);
        $data = [
            'rete' => 0,
//            'rete' => $rete["value"],
            'formatRete' => "$ " . number_format(($rete["value"]), 2, ',', '.'),
            'client' => $cli,
            'detail' => $detail,
            'exept' => "$ " . number_format(($totalExemp), 2, ',', '.'),
            'tax5num' => $totalTax5,
            'tax5' => "$ " . number_format((round($totalTax5)), 0, ',', '.'),
            'tax19num' => $totalTax19,
            'tax19' => "$ " . number_format((round($totalTax19)), 0, ',', '.'),
            'totalInvoice' => "$ " . number_format(($totalSum), 0, ',', '.'),
            'totalWithTax' => "$ " . number_format(($totalWithTax), 0, ',', '.'),
            'shipping' => "$ " . number_format((round($dep->shipping_cost)), 0, ',', '.'),
            'invoice' => $dep->invoice,
            'textTotal' => trim($tool->to_word(round($totalWithTax)))
        ];

//        return view('Inventory.departure.pdf',compact("data"));

        $pdf = \PDF::loadView('Inventory.departure.pdf', [], $data, [
                    'title' => 'Invoice']);
//  
        header('Content-Type: application/pdf');
//        return $pdf->download('factura_' . $dep["invoice"] . '_' . $cli["business_name"] . '.pdf');
        return $pdf->stream('factura_' . $dep["invoice"] . '_' . $cli["business_name"] . '.pdf');
    }

    public function dateText() {
        
    }

    public function getQuantity($id) {
        $product = \App\Models\Invoicing\PurchaseDetail::where("product_id", $id)->first();
        return response()->json(["response" => $product]);
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
//            unset($input["id"]);
//            $user = Auth::User();

            if (isset($input["detail"])) {

                try {

                    DB::beginTransaction();
                    $emDetail = null;

                    $input["header"]["status_id"] = 1;
                    $input["header"]["consecutive"] = $this->createConsecutive(3);

                    if (!isset($input["header"]["shipping_cost"])) {
                        $input["header"]["shipping_cost"] = 0;
                    }


                    $result = Departures::create($input["header"])->id;

                    if ($result) {
                        $this->updateConsecutive(3);
                        $resp = Departures::FindOrFail($result);

                        $input["detail"] = array_values(array_filter($input["detail"]));
                        $price_sf = 0;
                        foreach ($input["detail"] as $i => $val) {
                            $pro = Products::find($val["product_id"]);

                            $price_sf = $pro->price_sf;
                            if (Auth::user()->role_id == 1) {
                                if (isset($val["price_sf"]) && !empty($val["price_sf"])) {
                                    $price_sf = $val["price_sf"];
                                }
                            }

                            $detail["product_id"] = $val["product_id"];
                            $detail["departure_id"] = $result;
                            $detail["status_id"] = 1;
                            $detail["quantity"] = $val["quantity"];
                            $detail["units_sf"] = $pro->units_sf;
                            $detail["value"] = $price_sf;
                            DeparturesDetail::create($detail);
                        }

                        $detail = $this->formatDetail($result);


                        $ware = Warehouses::find($input["header"]["warehouse_id"]);

                        $client = Stakeholder::find($input["header"]["client_id"]);

                        $email = Email::where("description", "departures")->first();

                        if ($email != null) {
                            $emDetail = EmailDetail::where("email_id", $email->id)->get();
                        }

                        if (count($emDetail) > 0) {
                            $this->mails = array();
                            foreach ($emDetail as $value) {
                                $this->mails[] = $value->description;
                            }

                            $cit = Cities::find($ware->city_id);

                            $this->subject = "SuperFuds " . date("d/m") . " " . $client->business . " " . $cit->description . " " . $input["header"]["consecutive"];
                            $input["city"] = $cit->description;
                            $input["consecutive"] = $input["header"]["consecutive"];

                            $user = Users::find($input["header"]["responsible_id"]);

                            $input["name"] = ucwords($user->name);
                            $input["last_name"] = ucwords($user->last_name);
                            $input["phone"] = $user->phone;
                            $input["warehouse"] = $ware->description;
                            $input["address"] = $ware->address;
                            $input["detail"] = $detail;
                            $this->mails[] = $user->email;


                            Mail::send("Notifications.departure", $input, function($msj) {
                                $msj->subject($this->subject);
                                $msj->to($this->mails);
                            });
                        }
                        DB::commit();
                        return response()->json(['success' => true, "data" => $resp, "detail" => $detail]);
                    } else {
                        return response()->json(['success' => false]);
                    }
                } catch (Exception $exc) {
                    DB::rollback();
                    return response()->json(['success' => false, "msg" => "Wrong"], 409);
                }
            } else {
                return response()->json(['success' => false, "msg" => "detail Empty"], 409);
            }
        }
    }

    public function setSale(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();

            try {
                DB::beginTransaction();

                $basetax = Parameters::where("group", "tax")->where("code", 2)->first();
                $tax = Parameters::where("group", "tax")->where("code", 1)->first();
                $departure = Departures::find($input["id"]);

                $val = DeparturesDetail::where("departure_id", $departure["id"])->count();

                $dep = Sales::where("departure_id", $input["id"])->get();


                if ($val > 0) {
                    $val = DeparturesDetail::where("departure_id", $departure["id"])->where("status_id", 1)->count();
                    if ($val == 0) {
                        if (count($dep) == 0) {
                            $cons = $this->createConsecutive(5);


                            $id = DB::table("sales")->insertGetId(
                                    ["departure_id" => $departure["id"], "warehouse_id" => $departure["warehouse_id"], "responsible_id" => $departure["responsible_id"],
                                        "client_id" => $departure["client_id"], "city_id" => $departure["city_id"], "destination_id" => $departure["destination_id"],
                                        "address" => $departure["address"], "phone" => $departure["phone"],
                                        "status_id" => $departure["status_id"], "created" => $departure["created"], "consecutive" => $cons,
                                        "shipping_cost" => $departure["shipping_cost"]
                                    ]
                            );
//
                            $this->updateConsecutive(5);


                            $detail = DeparturesDetail::where("departure_id", $input["id"])->get();

                            $total = 0;
                            $cont = 0;
                            $credit = 0;
                            $tax = 0;
                            $totalPar = 0;


                            foreach ($detail as $value) {
                                $pro = Products::find($value->product_id);
                                $totalPar = $value->quantity * $value->value * $value->units_sf;
                                $total += $totalPar;

                                SaleDetail::insert([
                                    "sale_id" => $id, "product_id" => $value->product_id,
                                    "category_id" => $value->category_id, "quantity" => $value->quantity,
                                    "value" => $value->value, "tax" => $pro["tax"], "units_sf" => $value->units_sf,
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
                                $rete = Parameters::where("group", "tax")->where("code", 1)->first();
                                $rete = ($total * $rete["value"]);
                                SaleDetail::insert([
                                    "sale_id" => $id, "account_id" => 2, "value" => ($rete), "order" => $cont, "description" => "rete", "type_nature" => 2
                                ]);

                                $credit -= $rete;
                                $cont++;
                            }

                            SaleDetail::insert([
                                "account_id" => 2, "sale_id" => $id, "value" => $credit, "order" => $cont, "description" => "Clientes", "type_nature" => 2
                            ]);
                            $credit = 0;

//                            $departure->invoice = $this->createConsecutive(1);
                            $departure->status_id = 2;
                            $departure->save();
//                            $this->updateConsecutive(1);
                            $detail = $this->formatDetail($input["id"]);

                            DB::commit();
                            return response()->json(["success" => true, "header" => $departure, "detail" => $detail]);
                        } else {
                            return response()->json(["success" => false, "msg" => 'Already sended']);
                        }
                    } else {
                        return response()->json(["success" => false, "msg" => 'All item detail must be checked'], 409);
                    }
                } else {
                    return response()->json(["success" => false, "msg" => 'Detail empty'], 409);
                }
            } catch (Exception $exc) {
                DB::rollback();
                return response()->json(["success" => false, "msg" => 'Wrong'], 409);
            }
        }
    }

    public function createConsecutive($id) {
        $con = Consecutives::where("type_form", $id)->first();
        $con->current = ($con->current == null) ? 1 : $con->current + 1;
        $res = "";
        $con->pronoun = ($con->pronoun == null) ? '' : $con->pronoun;
        for ($i = strlen($con->pronoun); $i <= ($con->large - strlen($con->current)); $i++) {
            $res .= '0';
        }
        return $con->pronoun . $res . $con->current;
    }

    public function updateConsecutive($id) {
        $con = Consecutives::where("type_form", $id)->first();
        $con->current = ($con->current == null) ? 1 : $con->current + 1;
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
        $detail = $this->formatDetail($id);

        return response()->json(["header" => $entry, "detail" => $detail]);
    }

    public function formatDetail($id) {
        $detail = DB::table("departures_detail")
                ->select("departures_detail.id", "departures_detail.status_id", DB::raw("coalesce(departures_detail.description,'') as comment"), "departures_detail.real_quantity", "departures_detail.quantity", "departures_detail.value", DB::raw("products.reference ||' - ' ||products.title as product"), "departures_detail.description", "parameters.description as status", "stakeholder.business as stakeholder", "products.bar_code", "products.units_sf")
                ->join("products", "departures_detail.product_id", "products.id")
                ->join("stakeholder", "stakeholder.id", "products.supplier_id")
                ->join("parameters", "departures_detail.status_id", DB::raw("parameters.id and parameters.group='entry'"))
                ->where("departure_id", $id)
                ->orderBy("id", "asc")
                ->get();

        $this->total = 0;

        foreach ($detail as $i => $value) {
//            $detail[$i]->real_quantity = ($detail[$i]->real_quantity == null) ? $detail[$i]->quantity : $detail[$i]->real_quantity;
            $detail[$i]->valueFormated = "$ " . number_format($value->value, 2, ",", ".");
            $detail[$i]->total = $detail[$i]->quantity * $detail[$i]->value;
            $detail[$i]->totalFormated = "$ " . number_format($detail[$i]->total, 2, ",", ".");
            $detail[$i]->total_real = $detail[$i]->real_quantity * $detail[$i]->value;
            $detail[$i]->totalFormated_real = "$ " . number_format($detail[$i]->total_real, 2, ",", ".");
            $this->total += $detail[$i]->total;
            $this->total_real += $detail[$i]->total_real;
        }
        return $detail;
    }

    public function getDetail($id) {
        $detail = DeparturesDetail::FindOrFail($id);
        return response()->json($detail);
    }

    public function getAllDetail($departue_id) {
        $detail = $this->formatDetail($departue_id);
        return response()->json($detail);
    }

    public function update(Request $request, $id) {
        $entry = Departures::Find($id);
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
        $pro = Products::find($input["product_id"]);

        unset($input["value"]);

        if (Auth::user()->role_id == 4) {
            unset($input["real_quantity"]);
            $result = $entry->fill($input)->save();
            $resp = $this->formatDetail($input["departure_id"]);
            return response()->json(['success' => true, "data" => $resp]);
        }


        $stock = new StockController();
        $available = $stock->getDetailProduct($input["product_id"]);
        $available = $available->getData(true);

        $input["status_id"] = 3;
        if ($available["quantity"] == 0 && Auth::user()->role_id != 4) {
            $input["real_quantity"] = 0;
            $input["description"] = "Inventario no disponible, guarda 0";
            $entry->fill($input)->save();
            $resp = $this->formatDetail($input["departure_id"]);
            return response()->json(['success' => true, "data" => $resp, "msg" => "No se puede agregar se deja en 0"]);
        }

        if ($input["real_quantity"] != 0) {

            if ($available["quantity"] >= $input["real_quantity"]) {
                $result = $entry->fill($input)->save();
                if ($result) {
                    $resp = $this->formatDetail($input["departure_id"]);
                    return response()->json(['success' => true, "data" => $resp]);
                } else {
                    return response()->json(['success' => false, "msg" => "Quantity Not available"], 409);
                }
            } else {
                $available["quantity"] = ($available["quantity"] < 0) ? "0" . " Pending: " . ($available["quantity"] * -1) : $available["quantity"];
                return response()->json(['success' => false, "msg" => "Quantity Not available, " . $available["quantity"]]);
            }
        } else {

            $entry->fill($input)->save();
            $resp = $this->formatDetail($input["departure_id"]);
            return response()->json(['success' => true, "data" => $resp]);
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

            $resp = $this->formatDetail($entry["departure_id"]);
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
            $input["status_id"] = 1;
            $input["real_quantity"] = (!isset($input["real_quantity"]) || $input["real_quantity"] == '') ? null : $input["real_quantity"];

            $result = DeparturesDetail::create($input);
            if ($result) {

                $resp = $this->formatDetail($input["departure_id"]);
                return response()->json(['success' => true, "data" => $resp]);
            } else {
                return response()->json(['success' => false]);
            }
        }
    }

    public function generateInvoice($id) {
        $dep = Departures::findOrfail($id);
        $dep->invoice = $this->createConsecutive(1);
        $dep->save();
        $this->updateConsecutive(1);
        return response()->json(["success" => true, "consecutive" => $dep->invoice]);
    }

    public function storeExcel(Request $request) {
        if ($request->ajax()) {
            $error = 0;
            $input = $request->all();
            $this->name = '';
            $this->path = '';
            $file = array_get($input, 'file_excel');
            $this->name = $file->getClientOriginalName();
            $this->name = str_replace(" ", "_", $this->name);
            $this->path = "uploads/departures/" . date("Y-m-d") . "/" . $this->name;

            $file->move("uploads/departures/" . date("Y-m-d") . "/", $this->name);

            Excel::load($this->path, function($reader) {
                foreach ($reader->get() as $i => $book) {
                    $pro = Products::where("reference", (int) $book->sf_code)->first();

                    if ($pro != null) {
                        $price_sf = $pro->precio_unitario;
                        if (Auth::user()->role_id == 1) {

                            if (isset($book->precio_unitario) && !empty($book->precio_unitario)) {
                                $price_sf = $book->precio_unitario;
                            }
                        }

                        $this->listProducts[] = array(
                            "row" => $i,
                            "product_id" => $pro->id,
                            "product" => $pro->reference . " - " . $pro->title,
                            "quantity" => $book->unidades_total,
                            'price_sf' => $price_sf,
                            "valueFormated" => "$ " . number_format(($price_sf), 2, ',', '.'),
                            "totalFormated" => "$ " . number_format(($pro->units_sf * $price_sf * $book->unidades_total), 2, ',', '.'),
                            "real_quantity" => "",
                            "totalFormated_real" => "",
                            "comment" => "",
                            "status" => "new",
                        );
                    } else {
                        $this->errors[] = $book;
                    }
                }
            })->get();

            return response()->json(["success" => true, "data" => $this->listProducts, "error" => $this->errors]);
        }
    }

}
