<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Inventory\Sample;
use App\Models\Inventory\Orders;
use App\Models\Inventory\SampleDetail;
use App\Models\Inventory\OrdersDetail;
use App\Models\Invoicing\PurchasesDetail;
use App\Models\Invoicing\SaleDetail;
use App\Models\Administration\Products;
use App\Models\Administration\Stakeholder;
use App\Models\Administration\Parameters;
use App\Models\Administration\Branch;
use App\Models\Administration\Email;
use App\Models\Administration\EmailDetail;
use App\Models\Administration\Warehouses;
use App\Models\Administration\Cities;
use App\Models\Security\Users;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Inventory\StockController;
use App\Http\Controllers\ToolController;
use Mail;
use Datatables;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Administration\PricesSpecial;
use App\Http\Controllers\LogController;
use App\Models\Inventory\Inventory;
use App\Traits\NumberToString;
use App\Traits\StringExtra;
use App\Traits\SampleTool;

class SampleController extends Controller {

    use NumberToString;
    use StringExtra;
    use SampleTool;

    protected $tool;
    public $path;
    public $name;
    public $listProducts;
    public $errors;
    public $email;
    public $mails;
    public $log;
    public $in;

    public function __construct() {
        $this->middleware("auth");
        $this->tool = new ToolController();

        $this->path = '';
        $this->name = '';
        $this->listProducts = array();
        $this->errors = array();
        $this->email = array();
        $this->in = array();
        $this->mails = array();
        $this->log = new LogController();
    }

    public function index($client_id = null, $init = null, $end = null, $product_id = null, $supplier_id = null) {
        $category = \App\Models\Administration\Categories::all();
        $status = Parameters::where("group", "entry")->get();
        $type_inventory = Parameters::where("group", "type_inventory")->get();
        $commercial_id = null;

        return view("Inventory.sample.init", compact("category", "status", "client_id", "init", "end", "product_id", "supplier_id", "commercial_id", "type_inventory"));
    }

    public function listTable(Request $req) {
        $in = $req->all();

        $query = DB::table('vsample');

        if (isset($in["client_id"]) && $in["client_id"] != '' && $in["client_id"] != 0) {

            $query->where("client_id", $in["client_id"])
                    ->where("status_id", 2);
        }

        if (isset($in["init"]) && $in["init"] != '') {
            $query->whereBetween("dispatched", array($in["init"] . " 00:00", $in["end"] . " 23:59"));
        }

        if ($in["client_id"] == 0 && $in["client_id"] != '') {
            $query->where("status_id", 2);
        }

        if (Auth::user()->role_id != 1 && Auth::user()->role_id != 5) {
            $query->where("responsible_id", Auth::user()->id);
        }

//        if (Auth::user()->role_id == 5) {
//            $query->where("warehouse_id", Auth::user()->warehouse_id);
//        }

        if (isset($in["commercial_id"]) && $in["commercial_id"] != '') {
            $query->where("status_id", 2)->where("responsible_id", $in["commercial_id"]);
        }

        return Datatables::queryBuilder($query)->make(true);
    }

    public function showOrder($id) {
        return view("departure.init", compact("id"));
    }

    public function getClient($id) {
        $resp["client"] = Stakeholder::find($id);
        $resp["branch"] = Branch::where("stakeholder_id", $resp["client"]->id)->get();
        return response()->json(["success" => true, "data" => $resp]);
    }

    public function getBranch($id = null) {
        $response = array();

        if ($id != "null") {
            $response = Branch::find($id);
        }

        return response()->json(["response" => $response]);
    }

    public function getOrderExt($id) {
        $entry = Orders::findOrFail($id);
        $detail = DB::select("SELECT id,product_id,generate as quantity,value FROM orders_detail where order_id=" . $id);

        return response()->json(["header" => $entry, "detail" => $detail]);
    }

    public function pdf($id) {
        $data = [
            'foo' => 'bar'
        ];
        $pdf = PDF::loadView('departure.pdf', $data);
        return $pdf->stream('document.pdf');
    }

    public function getInvoiceHtml($id) {
        $sale = Sample::where("sample_id", $id)->first();
        $detail = SampleDetail::select("quantity,tax,description,product_id,products.title product")
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
        $this->mails = array();

        $sale = SampleDetail::where("sample_id", $id)->first();

        $detail = DB::table("samples_detail")
                ->select("quantity", DB::raw("samples_detail.tax * 100 as tax"), DB::raw("coalesce(samples_detail.description,'') as description"), "products.title as product", "products.id as product_id", "samples_detail.value", "samples_detail.units_sf", DB::raw("samples_detail.units_sf * samples_detail.quantity as quantityTotal"), DB::raw("samples_detail.value * samples_detail.quantity * samples_detail.units_sf as valueTotal"), "stakeholder.business as stakeholder")
                ->join("products", "samples_detail.product_id", "products.id")
                ->join("stakeholder", "products.supplier_id", "stakeholder.id")
                ->where("sample_id", $id)
                ->get();

        $dep = Sample::find($id);


        if ($dep->branch_id != '') {
            $cli = Branch::select("branch_office.id", "branch_office.business", "branch_office.business_name", "branch_office.document", "branch_office.address_invoice", "branch_office.term")
                    ->where("id", $dep->branch_id)
                    ->first();
        } else {
            $cli = Branch::select("branch_office.id", "branch_office.business", "branch_office.business_name", "branch_office.document", "branch_office.address_invoice", "branch_office.term")
                    ->where("stakeholder_id", $dep["client_id"])
                    ->first();
        }


        if ($cli == null) {
            $cli = Stakeholder::select("stakeholder.id", "stakeholder.business", "stakeholder.business_name", "stakeholder.document", "stakeholder.address_invoice", "stakeholder.term")
                    ->where("stakeholder.id", $dep["client_id"])
                    ->first();
        }


        $city_send = Cities::find($dep->destination_id);
        $city_inv = Cities::find($dep->city_id);


        $cli->city_send = $city_send->description;
        $cli->city_inv = $city_inv->description;

        $user = Users::find($dep["responsible_id"]);

        $ware = Warehouses::find($dep["warehouse_id"]);

        $this->email[] = $user->email;

        $term = 7;

        if ($cli["term"] != null) {
            $term = $cli["term"];
        }

        $expiration = date('Y-m-d', strtotime('+' . $term . ' days', strtotime($dep->dispatched)));

        $cli["address_send"] = $sale["address"];

        $cli["emition"] = $this->formatDate($sale["dispatched"]);
        $cli["observations"] = $sale["description"];
        $cli["expiration"] = $this->formatDate($expiration);

        $cli["responsible"] = ucwords($user->name . " " . $user->last_name);

        $totalExemp = 0;
        $totalTax5 = 0;
        $totalTax19 = 0;
        $tax = 0;
        $totalSum = 0;
        foreach ($detail as $i => $value) {
            $detail[$i]->valueFormated = "$" . number_format($value->value, 0, ',', '.');
            $detail[$i]->totalFormated = "$" . number_format($value->value * $value->units_sf * $value->quantity, 0, ',', '.');

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

        $rete = SampleDetail::where("description", "rete")->where("sample_id", $sale["id"])->first();

//        $totalWithTax = $totalSum + $totalTax19 + $totalTax5 + $dep->shipping_cost - ($rete["value"]);

        $totalWithTax = $totalSum + $totalTax19 + $totalTax5 + $dep->shipping_cost + (- $dep->discount);

        $cli["business_name"] = $this->cleanText($cli["business_name"]);
        $cli["business"] = $this->cleanText($cli["business"]);
        $cli["address_invoice"] = $dep->address_invoice;
//        dd($cli);

        $data = [
            'rete' => 0,
//            'rete' => $rete["value"],
            'formatRete' => "$ " . number_format(($rete["value"]), 2, ',', '.'),
            'client' => $cli,
            'detail' => $detail,
            'exept' => "$ " . number_format(($totalExemp), 2, ',', '.'),
            'tax5' => $totalTax5,
            'tax19' => $totalTax19,
            'totalInvoice' => "$ " . number_format(($totalSum), 0, ',', '.'),
            'totalWithTax' => "$ " . number_format(($totalWithTax), 0, ',', '.'),
            'shipping_cost' => $dep->shipping_cost,
            'invoice' => $dep->invoice,
            'textTotal' => trim($this->to_word(round($totalWithTax))),
            'discount' => $dep->discount
        ];
//dd($data);

        $pdf = \PDF::loadView('Inventory.sample.pdf', [], $data, [
                    'title' => 'Invoice']);
//        $pdf->SetProtection(array(), '123', '123');
//        $pdf->SetWatermarkImage('assets/images/logo.png');
//        $pdf->showWatermarkImage = true;
//        $pdf->WriteHTML('<watermarkimage src="public/assets/images/logo.png" alpha="0.4" size="200,250" />');

        header('Content-Type: application/pdf');
//        return $pdf->download('factura_' . $dep["invoice"] . '_' . $cli["business_name"] . '.pdf');
        return $pdf->stream('factura_' . $dep["invoice"] . '_' . $cli["business_name"] . '.pdf');
    }

    public function getRemission($id) {
        $this->mails = array();

        $dep = Sample::find($id);

        $detail = DB::table("samples_detail")
                ->select("samples_detail.quantity", DB::raw("samples_detail.tax * 100 as tax"), DB::raw("coalesce(samples_detail.description,'') as description"), "products.title as product", "products.id as product_id", "samples_detail.value", "samples_detail.units_sf", DB::raw("samples_detail.units_sf * samples_detail.quantity as quantityTotal"), DB::raw("samples_detail.value * samples_detail.quantity * samples_detail.units_sf as valueTotal"), "stakeholder.business as stakeholder")
                ->join("products", "samples_detail.product_id", "products.id")
                ->join("stakeholder", "products.supplier_id", "stakeholder.id")
                ->where("samples_detail.sample_id", $id)
                ->get();


        $cli = Branch::select("branch_office.id", "branch_office.business_name", "branch_office.document", "branch_office.address_invoice", "cities.description as city", "branch_office.term")
                ->where("stakeholder_id", $dep["client_id"])
                ->join("cities", "cities.id", "branch_office.city_id")
                ->first();

        if ($cli == null) {
            $cli = Stakeholder::select("stakeholder.id", "stakeholder.business_name", "stakeholder.document", "stakeholder.address_invoice", "cities.description as city", "stakeholder.term")
                    ->where("stakeholder.id", $dep["client_id"])
                    ->join("cities", "cities.id", "stakeholder.city_id")
                    ->first();
        }

        $user = Users::find($dep["responsible_id"]);

        $ware = Warehouses::find($dep["warehouse_id"]);

        $this->email[] = $user->email;


        $term = 7;

        if ($cli["term"] != null) {
            $term = $cli["term"];
        }


        $cli["address_invoice"] = $dep["address"];
        $cli["emition"] = $this->formatDate($dep["created_at"]);
        $cli["observations"] = $dep["description"];


        $cli["responsible"] = ucwords($user->name . " " . $user->last_name);

        $totalExemp = 0;
        $totalTax5 = 0;
        $totalTax19 = 0;
        $tax = 0;
        $totalSum = 0;
        foreach ($detail as $i => $value) {
            $detail[$i]->valueFormated = "$" . number_format($value->value, 0, ',', '.');
            $detail[$i]->totalFormated = "$" . number_format($value->value * $value->units_sf * $value->quantity, 0, ',', '.');

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

        $rete = SaleDetail::where("description", "rete")->where("sale_id", $dep["id"])->first();

//        $totalWithTax = $totalSum + $totalTax19 + $totalTax5 + $dep->shipping_cost - ($rete["value"]);
        $totalWithTax = $totalSum + $totalTax19 + $totalTax5 + $dep->shipping_cost;

        $cli["business_name"] = $this->cleanText($cli["business_name"]);
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
            'invoice' => $dep->remission,
            'textTotal' => trim($this->to_word(round($totalWithTax)))
        ];


        $pdf = \PDF::loadView('Inventory.sample.remission', [], $data, [
                    'title' => 'Invoice']);
//  
        header('Content-Type: application/pdf');
//        return $pdf->download('factura_' . $dep["invoice"] . '_' . $cli["business_name"] . '.pdf');
        return $pdf->stream('remission_' . $dep["remission"] . '_' . $cli["business_name"] . '.pdf');
    }

    public function reverse($id) {

        try {
            DB::beginTransaction();
            $row = Sample::find($id);

            $ayer = date("Y-m-d", strtotime("-1 day", strtotime(date("Y-m-d"))));

            if (strtotime($ayer) <= strtotime(date("Y-m-d", strtotime($row->dispatched)))) {
                $sal = Sample::where("sample_id", $id)->first();
                if ($sal != null) {
                    $detail = SaleDetail::where("sale_id", $sal->id)->get();

                    foreach ($detail as $value) {
                        $det = SaleDetail::find($value->id);
                        $det->delete();
                    }
                    $sal->delete();
                }

                $row->status_id = 1;
                $row->save();
                DB::commit();
                $dep = Sample::find($id);
                return response()->json(["success" => true, "header" => $dep]);
            } else {
                return response()->json(['success' => false, "msg" => "Fecha de emisión supera el tiempo permitido, 1 día"], 409);
            }
        } catch (Exception $exp) {
            DB::rollback();
            return response()->json(["success" => false], 409);
        }
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
                    $input["header"]["insert_id"] = Auth::user()->id;

                    if (!isset($input["header"]["shipping_cost"])) {
                        $input["header"]["shipping_cost"] = 0;
                    }

                    $result = Sample::create($input["header"])->id;

                    if ($result) {
                        $resp = Sample::Find($result);

                        $input["detail"] = array_values(array_filter($input["detail"]));

                        foreach ($input["detail"] as $i => $val) {
                            $pro = Products::find($val["product_id"]);
                            $detail["product_id"] = $val["product_id"];
                            $detail["sample_id"] = $result;
                            $detail["status_id"] = 1;
                            $detail["quantity"] = $val["quantity"];
                            $detail["units_sf"] = $pro->units_sf;
                            $detail["packaging"] = ($pro->packaging == null) ? 1 : $pro->packaging;
                            $detail["tax"] = $pro->tax;
                            $detail["value"] = $pro->price_sf;
                            $detail["cost_sf"] = $pro->cost_sf;

                            SampleDetail::create($detail);
                        }

                        $listdetail = $this->formatDetail($result);

                        $ware = Warehouses::find($input["header"]["warehouse_id"]);

                        $client = Stakeholder::find($input["header"]["client_id"]);

                        $email = Email::where("description", "muestras")->first();

                        if ($email != null) {
                            $emDetail = EmailDetail::where("email_id", $email->id)->get();
                        }

                        if (count($emDetail) > 0) {
                            $this->mails = array();

                            $userware = Users::find($ware->responsible_id);
                            $this->mails[] = $userware->email;

                            foreach ($emDetail as $value) {
                                $this->mails[] = $value->description;
                            }

                            $cit = Cities::find($ware->city_id);

                            $this->subject = "SuperFüds " . date("d/m") . " [Muestras] para Cliente: " . $client->business . " " . $cit->description . " " . $result;
                            $input["city"] = $cit->description;

                            $user = Users::find($input["header"]["responsible_id"]);

                            $input["name"] = ucwords($user->name);
                            $input["last_name"] = ucwords($user->last_name);
                            $input["phone"] = $user->phone;
                            $input["warehouse"] = $ware->description;
                            $input["address"] = $ware->address;
                            $input["detail"] = $listdetail;
                            $input["id"] = $result;
                            $input["environment"] = env("APP_ENV");
                            $input["created_at"] = $resp->created_at;

                            $input["subtotal"] = "$ " . number_format($this->subtotal, 0, ",", ".");
                            $input["total"] = "$ " . number_format($this->total, 0, ",", ".");
                            $input["exento"] = "$ " . number_format($this->total, 0, ",", ".");
                            $input["tax5"] = $this->tax5;
                            $input["tax19"] = $this->tax19;
                            $input["flete"] = $resp->shipping_cost;
                            $input["discount"] = $resp->discount;

                            $this->mails[] = $user->email;

                            if ($input["environment"] == 'local') {
                                $this->mails = Auth::User()->email;
                            }


                            Mail::send("Notifications.sample", $input, function($msj) {
                                $msj->subject($this->subject);
                                $msj->to($this->mails);
                            });

                            $this->log->logClient($client->id, "Genero Muestra " . $result);
                        }
                        $resp->subtotal = $this->subtotal;
                        $resp->quantity = $this->quantity;
                        $resp->total = $this->total;
                        $resp->save();

                        DB::commit();

                        $total = "$ " . number_format($this->total, 0, ",", ".");
                        return response()->json(['success' => true, "header" => $resp, "detail" => $listdetail, "total" => $total]);
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

                $departure = Sample::find($input["id"]);
                $val = SampleDetail::where("sample_id", $departure["id"])->count();


                $dep = Sample::where("id", $input["id"])->where("status_id", 2)->get();
                if ($val > 0) {
//                    $val = SampleDetail::where("sample_id", $departure["id"])->where("status_id", 1)->count();
                    $val = SampleDetail::where("sample_id", $departure["id"])->where("real_quantity", ">", 0)->where("status_id", 3)->get();

                    if ($val != null) {
                        if (count($dep) == 0) {

                            $con = Sample::select(DB::raw("(invoice::int + 1) consecutive"))->whereNotNull("invoice")->orderBy(DB::raw("invoice::int "), "desc")->first();

                            if ($departure->invoice == '') {
                                $consecutive = ($con == null) ? 1 : $con->consecutive;
                                $departure->invoice = $consecutive;
                            }

                            $departure->status_id = 2;
                            $departure->dispatched = date("Y-m-d H:i:s");
                            $departure->save();

                            $detail = SampleDetail::where("sample_id", $input["id"])->where("real_quantity", ">", 0)->get();

                            $cont = 0;

                            foreach ($detail as $value) {
                                $rowDep = SampleDetail::find($value->id);
                                $this->tool->substract($value->id, $value);
                            }

                            $detail = $this->formatDetail($input["id"]);
                            $departure = Sample::find($input["id"]);
                            $total = "$ " . number_format($this->total, 0, ",", ".");

                            $this->log->logClient($departure->client_id, "Genero Petición de Muestra # " . $departure->invoice);

                            $email = Email::where("description", "muestras")->first();

                            if ($email != null) {
                                $emDetail = EmailDetail::where("email_id", $email->id)->get();
                            }

                            if (count($emDetail) > 0) {

                                $ware = Warehouses::find($departure->warehouse_id);
                                $client = Stakeholder::find($departure->client_id);
                                $sales = Sample::find($departure->id);
                                $this->mails = array();

                                $userware = Users::find($ware->responsible_id);
                                $this->mails[] = $userware->email;

                                foreach ($emDetail as $value) {
                                    $this->mails[] = $value->description;
                                }

                                $listdetail = $this->formatDetail($departure->id);

                                $cit = Cities::find($ware->city_id);
                                $commercial = Users::where("id", $departure->responsible_id)->first();
                                $this->subject = "SuperFüds " . date("d/m") . " [Muestras] para Cliente: " . $client->business . " " . $cit->description . " " . $departure->id . " [Despachado]";
                                $input["city"] = $cit->description;

                                $user = Users::find($departure->responsible_id);
                                $term = 7;

                                if ($client->term != null) {
                                    $term = $client->term;
                                }
                                $input["client"] = ucwords($client->business);
                                $input["address"] = ucwords($client->business);
                                $input["document"] = $client->document;
                                $input["address_send"] = $client->address_send;
                                $input["address_invoice"] = $client->address_invoice;
                                $input["dispatched"] = $departure->dispatched;
                                $input["expiration"] = date('Y-m-d', strtotime('+' . $term . ' days', strtotime($departure->dispatched)));

                                $input["responsible"] = $commercial->name . " " . $commercial->last_name;
                                $input["observation"] = $departure->description;
                                $input["city"] = $cit->description;
                                $input["detail"] = $listdetail;
                                $input["id"] = $departure->id;
                                $input["environment"] = env("APP_ENV");
                                $input["created_at"] = $departure->created_at;
                                $input["textTotal"] = trim($this->to_word(round($this->total)));

                                $input["subtotal"] = "$ " . number_format($this->subtotal, 0, ",", ".");
                                $input["total"] = "$ " . number_format($this->total, 0, ",", ".");
                                $input["exento"] = "$ " . number_format($this->exento, 0, ",", ".");
                                $input["tax5f"] = "$ " . number_format($this->tax5, 0, ",", ".");
                                $input["tax5"] = $this->tax5;
                                $input["tax19f"] = "$ " . number_format($this->tax19, 0, ",", ".");
                                $input["tax19"] = $this->tax19;
                                $input["flete"] = "$ " . number_format($departure->shipping_cost, 0, ",", ".");
                                $input["discount"] = $departure->discount;

                                $this->mails[] = $user->email;

                                if ($input["environment"] == 'local') {
                                    $this->mails = Auth::User()->email;
                                }

                                Mail::send("Notifications.sampleDep", $input, function($msj) {
                                    $msj->subject($this->subject);
                                    $msj->to($this->mails);
                                });
                            }

                            $departure->quantity = $this->quantity_real;
                            $departure->total = $this->total_real + $departure->shipping_cost;
                            $departure->subtotal = $this->subtotal_real;
                            $departure->save();

                            DB::commit();
                            return response()->json(["success" => true, "header" => $departure, "detail" => $detail, "total" => $total]);
                        } else {
                            DB::rollback();
                            return response()->json(["success" => false, "msg" => 'Already sended']);
                        }
                    } else {
                        DB::rollback();
                        return response()->json(["success" => false, "msg" => 'All item detail must be checked'], 409);
                    }
                } else {
                    DB::rollback();
                    return response()->json(["success" => false, "msg" => 'Detail empty'], 409);
                }
            } catch (Exception $exc) {
                DB::rollback();
                return response()->json(["success" => false, "msg" => 'Wrong'], 409);
            }
        }
    }

    public function testDepNotification($id) {
        $name = "jorge";
        $last_name = "Pinedo";
        $id = 1;
        $created_at = date("Y-m-d H:i");
        $warehouse = "jorge";
        $detail = $this->formatDetail(297);
        $subtotal = "$ " . number_format($this->subtotal, 0, ",", ".");
        $total = "$ " . number_format($this->total, 0, ",", ".");
        $exento = "$ " . number_format($this->total, 0, ",", ".");
        $tax5f = "$ " . number_format($this->tax5, 0, ",", ".");
        $tax5 = $this->tax5;
        $tax19f = "$ " . number_format($this->tax19, 0, ",", ".");
        $tax19 = $this->tax19;
        $flete = "$ " . number_format($this->flete, 0, ",", ".");
        $environment = "production";
        return view("Notifications.departure", compact("name", "last_name", "id", "created_at", "detail", "warehouse", "subtotal", "total", "exento", "tax5f", "tax5", "tax19f", "tax19", "environment"));
    }

    public function testInvoiceNotification($id) {
        $name = "jorge";
        $last_name = "Pinedo";
        $id = 1;
        $created_at = date("Y-m-d H:i");
        $warehouse = "jorge";
        $detail = $this->formatDetail(297);
        $subtotal = "$ " . number_format($this->subtotal, 0, ",", ".");
        $total = "$ " . number_format($this->total, 0, ",", ".");
        $exento = "$ " . number_format($this->total, 0, ",", ".");
        $tax5f = "$ " . number_format($this->tax5, 0, ",", ".");
        $tax5 = $this->tax5;
        $tax19f = "$ " . number_format($this->tax19, 0, ",", ".");
        $tax19 = $this->tax19;
        $flete = "$ " . number_format(100000, 0, ",", ".");
        $environment = "production";
        $invoice = "3022";
        return view("Notifications.invoice", compact("name", "last_name", "id", "created_at", "detail", "warehouse", "subtotal", "total", "exento", "tax5f", "tax5", "tax19f", "tax19", "environment", "invoice"));
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


                SampleDetail::insert([
                    'sample_id' => $id, "value" => $value->value, "product_id" => $value->product_id, "category_id" => $value->category_id,
                    "quantity" => $value->generate
                ]);


                OrdersDetail::where("id", $value->id)->update(["generate" => $value->generate, "pending" => $value->quantity]);
            }
        }
        $resp = Sample::FindOrFail($id);
        $detail = SampleDetail::where("sample_id", $id)->get();

        return response()->json(["success" => true, "header" => $resp, "detail" => $detail]);
    }

    public function edit($id) {
        $header = Sample::FindOrFail($id);
        $data["header"] = $header;
        return response()->json($this->formatDetailJSON($data, $id));
    }

    public function getDetail($id) {
        $detail = SampleDetail::FindOrFail($id);
        $header = Sample::find($detail->sample_id);
        $inventory = Inventory::where("product_id", $detail->product_id)->where("warehouse_id", $header->warehouse_id)->get();
        return response()->json(["row" => $detail, "inventory" => $inventory]);
    }

    public function getAllDetail($departue_id) {
        $detail = $this->formatDetail($departue_id);
        return response()->json(["detail" => $detail, "total" => "$ " . number_format($this->total, 2, ",", ".")]);
    }

    public function update(Request $request, $id) {
        $entry = Sample::Find($id);
        $input = $request->all();
        $result = $entry->fill($input)->save();
        if ($result) {
            $resp = Sample::FindOrFail($id);
            return response()->json(['success' => true, "data" => $resp]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function cancelInvoice(Request $request, $id) {
        $in = $request->all();
        $row = Sample::Find($id);

        $ayer = date("Y-m-d", strtotime("-1 day", strtotime(date("Y-m-d"))));

        if (strtotime($ayer) <= strtotime(date("Y-m-d", strtotime($row->dispatched)))) {
            $row->description = "Cancelado: " . $in["description"] . ", " . $row->description;
            $row->status_id = 4;
            $row->save();
            $resp = Sample::FindOrFail($id);
            return response()->json(['success' => true, "data" => $resp]);
        } else {
            return response()->json(['success' => false, "msg" => "Fecha de emisión supera el tiempo permitido, 1 día"], 409);
        }
    }

    public function updateDetail(Request $request, $id) {
        $input = $request->all();
        $row = SampleDetail::find($id);

        $header = Sample::find($row->sample_id);

        $special = PricesSpecial::where("product_id", $input["header"]["product_id"])
                        ->where("client_id", $header->client_id)->first();

        if ($special == null) {
            $pro = Products::find($input["header"]["product_id"]);
        } else {
            $pro = DB::table("products")
                    ->select("products.id", "prices_special.price_sf", "products.cost_sf", "products.units_sf", 'products.tax', "products.reference")
                    ->join("prices_special", "prices_special.product_id", "=", "products.id")
                    ->where("products.id", $input["header"]["product_id"])
                    ->first();
        }

        $input["cost_sf"] = $pro->cost_sf;

        $input["quantity_lots"] = json_encode($input["detail"]);
        $input["real_quantity"] = $input["header"]["total"];
        $input["status_id"] = 3;


        foreach ($input["detail"] as $value) {
            $this->tool->addInventoryHold($header->warehouse_id, $pro->reference, $value["quantity"], $value["lot"], $value["expiration_date"], $value["cost_sf"], $row->id);
        }


        $row->fill($input)->save();
        $resp = $this->formatDetail($header->id);
        $total = "$ " . number_format($this->total, 0, ",", ".");
        return response()->json(['success' => true, "header" => $header, "detail" => $resp, "total" => $total]);
    }

    public function destroy($id) {
        $row = Sample::Find($id);
        $row->delete();
        $detail = SampleDetail::where("sample_id", $row->id)->get();
        foreach ($detail as $value) {
            $det = SampleDetail::find($value->id);
            $det->delete();
        }

        if ($id) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function destroyDetail($id) {
        $entry = SampleDetail::FindOrFail($id);
        $result = $entry->delete();
        if ($result) {
            $header = Sample::find($entry["sample_id"]);
            $resp = $this->formatDetail($entry["sample_id"]);
            $total = "$ " . number_format($this->total, 0, ",", ".");
            return response()->json(['success' => true, "header" => $header, "detail" => $resp, 'total' => $total]);
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

            $product = Products::find($input["product_id"]);
            $input["value"] = $product->price_sf;
            $input["units_sf"] = $product->units_sf;
            $input["tax"] = $product->tax;
            $input["packaging"] = $product->packaging;

            $result = SampleDetail::create($input);
            if ($result) {
                $resp = $this->formatDetail($input["sample_id"]);
                $total = "$ " . number_format($this->total, 0, ",", ".");
                $header = Sample::find($input["sample_id"]);
                return response()->json(['success' => true, "header" => $header, "detail" => $resp, "total" => $total]);
            } else {
                return response()->json(['success' => false]);
            }
        }
    }

    public function generateRemission($id) {
        $row = Sample::find($id);
        $con = Sample::select(DB::raw("count(*) +1 consecutive"))->whereNotNull("remission")->first();
        $row->status_id = 5;
        $row->remission = $con->consecutive;
        $row->save();
        return response()->json(['success' => true]);
    }

    public function generateInvoice($id) {
//        $sale = SampleDetail::where("sample_id", $id)->first();

        $sale = Sample::find($id)->toArray();


        $detail = DB::table("samples_detail")
                ->select("quantity", DB::raw("samples_detail.tax * 100 as tax"), DB::raw("coalesce(samples_detail.description,'') as description"), "products.title as product", "products.id as product_id", "samples_detail.value", "samples_detail.units_sf", DB::raw("samples_detail.units_sf * samples_detail.quantity as quantityTotal"), DB::raw("samples_detail.value * samples_detail.quantity * samples_detail.units_sf as valueTotal"), "stakeholder.business as stakeholder")
                ->join("products", "samples_detail.product_id", "products.id")
                ->join("stakeholder", "products.supplier_id", "stakeholder.id")
                ->where("sample_id", $sale["id"])
                ->get();


        $cli = Stakeholder::select("stakeholder.id", "stakeholder.business_name", "stakeholder.document", "stakeholder.address_invoice", "cities.description as city", "stakeholder.term")
                ->where("stakeholder.id", $sale["client_id"])
                ->join("cities", "cities.id", "stakeholder.city_id")
                ->first();

        $user = Users::find($sale["responsible_id"]);
        $totalExemp = 0;
        $totalTax5 = 0;
        $totalTax19 = 0;
        $tax = 0;
        $totalSum = 0;
        foreach ($detail as $i => $value) {
            $detail[$i]->valueFormated = "$" . number_format($value->value, 0, ',', '.');
            $detail[$i]->totalFormated = "$" . number_format($value->value * $value->units_sf * $value->quantity, 0, ',', '.');

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

        $ware = Warehouses::find($sale["warehouse_id"]);

        $email = Email::where("description", "invoices")->first();

        if ($email != null) {
            $emDetail = EmailDetail::where("email_id", $email->id)->get();
        }


        if (count($emDetail) > 0) {

            foreach ($emDetail as $value) {
                $this->mails[] = $value->description;
            }
        }

        if (count($this->mails) > 0) {
            $cit = Cities::find($ware->city_id);
            $this->subject = "SuperFuds " . date("d/m") . " " . $cli->business . " " . $cit->description . " Despacho de Pedido, factura " . $sale["invoice"];
            $input["city"] = $cit->description;
            $input["consecutive"] = $sale["id"];
            $input["invoice"] = $sale["invoice"];
            $input["dispatched"] = $sale["dispatched"];
            $input["flete"] = $sale["shipping_cost"];
            $input["tax5"] = 0;
            $input["tax19"] = 0;
            $input["discount"] = 0;

            $input["name"] = ucwords($user->name);
            $input["last_name"] = ucwords($user->last_name);
            $input["phone"] = $user->phone;
            $input["warehouse"] = $ware->description;
            $input["address"] = $ware->address;
            $input["detail"] = $detail;
            $input["environment"] = env("APP_ENV");
            $input["created_at"] = date("Y-m-d");

            $this->mails[] = $user->email;


            Mail::send("Notifications.invoice", $input, function($msj) {
                $msj->subject($this->subject);
                $msj->to($this->mails);
            });
        }

        return response()->json(["success" => true, "consecutive" => $dep->invoice]);
    }

    public function storeExcel(Request $request) {
        if ($request->ajax()) {
            $error = 0;
            $this->in = $request->all();
            $this->name = '';
            $this->path = '';
            $file = array_get($this->in, 'file_excel');
            $this->name = $file->getClientOriginalName();
            $this->name = str_replace(" ", "_", $this->name);
            $this->path = "uploads/departures/" . date("Y-m-d") . "/" . $this->name;

            $file->move("uploads/departures/" . date("Y-m-d") . "/", $this->name);

            Excel::load($this->path, function($reader) {
                $special = null;
                foreach ($reader->get() as $i => $book) {

                    if ($book->unidades_total != 0) {
                        if (isset($book->item) && $book->item != '') {

                            $special = PricesSpecial::where("item", (int) $book->item)->where("client_id", $this->in["client_id"])->first();
                            if ($special == null) {
                                $product_id = 0;
                            } else {
                                $product_id = $special->product_id;
                            }

                            $pro = Products::find($product_id);
                            if ($pro == null) {
                                $pro = Products::where("reference", (int) $book->sf_code)->first();
                            }

                            if ($pro == null) {
                                $pro = Products::where("bar_code", $book->ean)->first();
                            }
                        } else if (isset($book->ean) && $book->ean != '') {
                            if (isset($book->ean) && $book->ean != '') {
                                $pro = Products::where("bar_code", $book->ean)->first();
                            } else {
                                $pro = Products::where("reference", (int) $book->sf_code)->first();
                            }
                            if ($pro != null) {
                                $special = PricesSpecial::where("product_id", $pro->id)->where("client_id", $this->in["client_id"])->first();
                            }
                        } else {
                            if (isset($book->sf_code) && $book->sf_code != '') {
                                $pro = Products::where("reference", $book->sf_code)->first();
                            }
                        }

                        if ($pro != null) {
                            if ($special == null) {
                                $price_sf = $pro->price_sf;
                            } else {
                                $price_sf = $special->price_sf;
                            }

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
                                "units_sf" => $pro->units_sf,
                                'price_sf' => $price_sf,
                                "valueFormated" => "$ " . number_format(($price_sf), 2, ',', '.'),
                                "totalFormated" => "$ " . number_format(($pro->units_sf * $price_sf * $book->unidades_total), 2, ',', '.'),
                                "real_quantity" => "",
                                "totalFormated_real" => "",
                                "comment" => "",
                                "status" => "new",
                            );

                            $this->total += ($price_sf * $book->unidades_total * $pro->units_sf);
                        } else {
                            $this->errors[] = $book;
                        }
                    }
                }
            })->get();

            return response()->json(["success" => true, "data" => $this->listProducts, "error" => $this->errors, "total" => "$ " . number_format(($this->total), 0, ',', '.')]);
        }
    }

}
