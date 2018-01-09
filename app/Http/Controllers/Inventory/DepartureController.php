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
use Datatables;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Administration\PricesSpecial;
use App\Http\Controllers\LogController;
use App\Models\Sales\BriefCase;

class DepartureController extends Controller {

    protected $total;
    protected $total_real;
    protected $tool;
    protected $subtotal;
    protected $subtotal_real;
    protected $exento;
    protected $exento_real;
    protected $tax19;
    protected $tax19_real;
    protected $tax5;
    protected $tax5_real;
    public $path;
    public $name;
    public $listProducts;
    public $errors;
    public $email;
    public $mails;
    public $log;
    public $in;
    public $initdate;

    public function __construct() {
        $this->middleware("auth");
        $this->tool = new ToolController();
        $this->exento = 0;
        $this->exento_real = 0;
        $this->tax19 = 0;
        $this->tax19_real = 0;
        $this->tax5 = 0;
        $this->tax5_real = 0;
        $this->total = 0;
        $this->subtotal = 0;
        $this->total_real = 0;
        $this->path = '';
        $this->name = '';
        $this->listProducts = array();
        $this->errors = array();
        $this->email = array();
        $this->in = array();
        $this->mails = array();
        $this->log = new LogController();
        $this->initdate = date('Y-m-d', strtotime('-1 month', strtotime(date('Y-m-d'))));
    }

    public function index($client_id = null, $init = null, $end = null, $product_id = null, $supplier_id = null) {
        $category = \App\Models\Administration\Categories::all();
        $status = Parameters::where("group", "entry")->get();
        $commercial_id = null;
        if (strpos($client_id, "_") == false) {
            $commercial_id = str_replace("_", "", $client_id);
            $client_id = null;
        }

        $initdate = $this->initdate;


        return view("Inventory.departure.init", compact("category", "status", "client_id", "init", "end", "product_id", "supplier_id", "commercial_id", "initdate"));
    }

    public function listTable(Request $req) {
        $in = $req->all();
        $cont = 0;

        $query = DB::table('vdepartures');


        if (isset($in["client_id"]) && $in["client_id"] != '' && $in["client_id"] != 0) {

            $query->where("client_id", $in["client_id"])
                    ->where("status_id", 2);
        }

        if (isset($in["init"]) && $in["init"] != '') {
            $query->whereBetween("dispatched", array($in["init"] . " 00:00", $in["end"] . " 23:59"));
        }


        if (isset($in["id_filter"]) && $in["id_filter"] != '') {
            $cont++;
            $query->where("id", $in["id_filter"]);
        }

        if (isset($in["invoice_filter"]) && $in["invoice_filter"] != '') {
            $cont++;
            $query->where("invoice", $in["invoice_filter"]);
        }

        if (isset($in["responsible_filter"]) && $in["responsible_filter"] != '') {
            $cont++;
            $query->where("responsible_id", $in["responsible_filter"]);
        }

        if (isset($in["end_filter"]) && $in["end_filter"] != '') {
            $cont++;
            $query->where("created_at", "<=", $in["end_filter"] . " 00:00");
        }


        if ($in["client_filter"] != 0 && $in["client_filter"] != '') {
            $query->where("client_id", $in["client_filter"]);
        }

        if ($cont == 0) {
            if (isset($in["init_filter"]) && $in["init_filter"] != '') {
                $query->where("created_at", ">=", $in["init_filter"] . " 00:00");
            } else {
                $query->where("created_at", ">=", $this->initdate . " 00:00");
            }
        }

        if (Auth::user()->role_id != 1 && Auth::user()->role_id != 5) {
            $query->where("responsible_id", Auth::user()->id);
        }

        if (Auth::user()->role_id == 5) {
            $query->where("warehouse_id", Auth::user()->warehouse_id);
        }


        if (isset($in["commercial_id"]) && $in["commercial_id"] != '') {
            $query->where("status_id", 2)->where("responsible_id", $in["commercial_id"]);
        }


//        if (isset($in["supplier_id"]) && $in["supplier_id"] != '' && $in["supplier_id"] != 0) {
//            $pro = Products::select("id")->where("supplier_id", $in["supplier_id"])->get();
//            
//            DB::select("")
//            
//            dd($pro);
//        }

        return Datatables::queryBuilder($query)->make(true);
    }

    public function showOrder($id) {
        return view("departure.init", compact("id"));
    }

    public function getClient($id) {
        $resp["client"] = Stakeholder::find($id);
        $resp["branch"] = Branch::where("stakeholder_id", $resp["client"]->id)->get();

        $query = DB::table("vbriefcase")
                ->where("client_id", $id)
                ->where("dias_vencidos", ">", 0);


        $query->where(function($query) {
            $query->whereNull("paid_out")
                    ->orWhere("paid_out", "=", false);
        });

        $resp["briefcase"] = $query->get();

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
        $this->mails = array();

//        if(file_exists(public_path()."/images/superfuds.png")){
//            echo "asd";exit;
//        }
//        
//        echo public_path()."/images/superfuds.png";exit;

        $sale = Sales::where("departure_id", $id)->first();
        $detail = $this->formatDetailSales($sale["id"]);

        $dep = Departures::find($id);
        $cli = null;
        if ($dep->branch_id != '') {
            $cli = Branch::select("branch_office.id", "branch_office.business", "branch_office.business_name", "branch_office.document", "branch_office.address_invoice", "branch_office.term", "branch_office.phone")
                    ->where("id", $dep->branch_id)
                    ->first();
        } else {
            $cli = Stakeholder::select("stakeholder.id", "stakeholder.business", "stakeholder.business_name", "stakeholder.document", "stakeholder.address_invoice", "stakeholder.term", "stakeholder.phone")
                    ->where("stakeholder.id", $sale["client_id"])
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

        $expiration = date('Y-m-d', strtotime('+' . $term . ' days', strtotime($sale["dispatched"])));

        $cli["address_send"] = $sale["address"];

        $cli["emition"] = $this->formatDate($sale["dispatched"]);
        $cli["observations"] = $sale["description"];
        $cli["expiration"] = $this->formatDate($expiration);

        $cli["responsible"] = ucwords($user->name . " " . $user->last_name);
        $cli["phone"] = $cli->phone;

        $totalExemp = 0;
        $totalTax5 = 0;
        $totalTax19 = 0;
        $tax = 0;
        $totalSum = 0;


        $rete = SaleDetail::where("description", "rete")->where("sale_id", $sale["id"])->first();

//        $totalWithTax = $totalSum + $totalTax19 + $totalTax5 + $dep->shipping_cost - ($rete["value"]);
        $shipping_cost_tax = 0;

        if ($dep->shipping_cost_tax == 0.05) {
            $shipping_cost_tax = $dep->shipping_cost * $dep->shipping_cost_tax;

            $this->tax5 += $shipping_cost_tax;
        }

        if ($dep->shipping_cost_tax == 0.19) {
            $shipping_cost_tax = $dep->shipping_cost * $dep->shipping_cost_tax;
            $this->tax19 += $shipping_cost_tax;
        }

        $this->subtotal += $dep->shipping_cost;

        $totalWithTax = $this->subtotal + $this->tax19 + $this->tax5 + (- $dep->discount);

        $cli["business_name"] = $this->tool->cleanText($cli["business_name"]);
        $cli["business"] = $this->tool->cleanText($cli["business"]);
        $cli["address_invoice"] = $dep->address_invoice;

        $data = [
            'rete' => 0,
            'formatRete' => "$ " . number_format(($rete["value"]), 2, ',', '.'),
            'client' => $cli,
            'detail' => $detail,
            'exept' => $this->exento,
            'tax5' => $this->tax5,
            'tax19' => $this->tax19,
            'totalInvoice' => "$ " . number_format(($this->subtotal), 0, ',', '.'),
            'totalWithTax' => "$ " . number_format(($totalWithTax), 0, ',', '.'),
            'shipping_cost' => $dep->shipping_cost,
            'invoice' => $dep->invoice,
            'textTotal' => trim($this->tool->to_word(round($totalWithTax))),
            'discount' => $dep->discount
        ];

//        dd($data);
        $pdf = \PDF::loadView('Inventory.departure.pdf', [], $data, [
                    'title' => 'Invoice',
                    'margin_top' => -12, "margin_bottom" => 1]);

//        $pdf->SetProtection(array(), '123', '123');
//          $pdf->showWatermarkImage = true;
//        $pdf->SetWatermarkImage(url("/").'/assets/images/logo.png');

        header('Content-Type: application/pdf');
//        return $pdf->download('factura_' . $dep["invoice"] . '_' . $cli["business_name"] . '.pdf');
        return $pdf->stream('factura_' . $dep["invoice"] . '_' . $cli["business_name"] . '.pdf');
    }

    public function getRemission($id) {
        $this->mails = array();

        $dep = Departures::find($id);

        $detail = DB::table("departures_detail")
                ->select("departures_detail.quantity", DB::raw("departures_detail.tax * 100 as tax"), DB::raw("coalesce(departures_detail.description,'') as description"), "products.title as product", "products.id as product_id", "departures_detail.value", "departures_detail.units_sf", DB::raw("departures_detail.units_sf * departures_detail.quantity as quantityTotal"), DB::raw("departures_detail.value * departures_detail.quantity * departures_detail.units_sf as valueTotal"), "stakeholder.business as stakeholder")
                ->join("products", "departures_detail.product_id", "products.id")
                ->join("stakeholder", "products.supplier_id", "stakeholder.id")
                ->where("departures_detail.departure_id", $id)
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


        $shipping_cost_tax = 0;

        if ($dep->shipping_cost_tax == 0.05) {
            $shipping_cost_tax = $dep->shipping_cost * $dep->shipping_cost_tax;
            $totalTax5 += $shipping_cost_tax;
        }

        if ($dep->shipping_cost_tax == 0.19) {
            $shipping_cost_tax = $dep->shipping_cost * $dep->shipping_cost_tax;
            $totalTax19 += $shipping_cost_tax;
        }

        $totalSum += $dep->shipping_cost;

        $totalWithTax = $totalSum + $totalTax19 + $totalTax5 + (- $dep->discount);



        $cli["business_name"] = $this->tool->cleanText($cli["business_name"]);
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
            'textTotal' => trim($this->tool->to_word(round($totalWithTax)))
        ];


        $pdf = \PDF::loadView('Inventory.departure.remission', [], $data, [
                    'title' => 'Invoice']);
//  
        header('Content-Type: application/pdf');
//        return $pdf->download('factura_' . $dep["invoice"] . '_' . $cli["business_name"] . '.pdf');
        return $pdf->stream('remission_' . $dep["remission"] . '_' . $cli["business_name"] . '.pdf');
    }

    public function reverse($id) {
        try {
            DB::beginTransaction();
            $row = Departures::find($id);

            $ayer = date("Y-m-d", strtotime("-5 day", strtotime(date("Y-m-d"))));


            if (strtotime($ayer) <= strtotime(date("Y-m-d", strtotime($row->dispatched))) || $row->status_id == 5 || Auth::user()->id == 2) {
                $sal = Sales::where("departure_id", $id)->first();
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
                $dep = Departures::find($id);




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

            $query = DB::table("vbriefcase")
                    ->where("client_id", $input["header"]["client_id"])
                    ->where("dias_vencidos", ">", 0);


            $query->where(function($query) {
                $query->whereNull("paid_out")
                        ->orWhere("paid_out", "=", false);
            });


            $validateBriefcase = $query->get();

            if (isset($input["detail"])) {

                $status = (count($validateBriefcase) > 0) ? 8 : 1;
                $input["header"]["status_id"] = $status;

                if (!isset($input["header"]["shipping_cost"])) {
                    $input["header"]["shipping_cost"] = 0;
                }
                $input["detail"] = array_values(array_filter($input["detail"]));
                $input["header"]["type_request"] = "web";

                return $this->processDeparture($input["header"], $input["detail"]);
            } else {
                return response()->json(['success' => false, "msg" => "detail Empty"], 409);
            }
        }
    }

    /**
     * 

     * 
     * @param type $header
     * @param type $detail
     * @return type
     */
    public function processDeparture($header, $detail) {
        try {
            DB::beginTransaction();
            $header["insert_id"] = Auth::user()->id;

            if (isset($header["branch_id"]) && $header["branch_id"] != 0) {
                $bra = Branch::find($header["branch_id"]);
                $header["responsible_id"] = $bra->responsible_id;
            }

            $result = Departures::create($header)->id;

            if ($result) {
                $emDetail = null;

                $resp = Departures::Find($result);

                $detail = array_values(array_filter($detail));
                $price_sf = 0;
                $tax19 = 0;
                $tax5 = 0;

                foreach ($detail as $i => $val) {
                    $product_id = (is_array($val)) ? $val["product_id"] : $val->product_id;
                    $quantity = (is_array($val)) ? $val["quantity"] : $val->quantity;


                    $special = PricesSpecial::where("product_id", $product_id)
                                    ->where("client_id", $header["client_id"])->first();

                    if ($special == null) {
                        $pro = Products::find($product_id);
                    } else {
                        $pro = DB::table("products")
                                ->select("products.id", "prices_special.price_sf", "prices_special.units_sf", 'prices_special.tax', "prices_special.packaging")
                                ->join("prices_special", "prices_special.product_id", "products.id")
                                ->where("prices_special.id", $special->id)
                                ->first();
                    }

                    $price_sf = $pro->price_sf;
                    if (Auth::user()->role_id == 1) {
                        if (isset($val["price_sf"]) && !empty($val["price_sf"])) {
                            $price_sf = $val["price_sf"];
                        }
                    }

                    $new["product_id"] = $product_id;
                    $new["departure_id"] = $result;
                    $new["status_id"] = 1;
                    $new["quantity"] = $quantity;
                    $new["units_sf"] = $pro->units_sf;
                    $new["packaging"] = ($pro->packaging == null) ? 1 : $pro->packaging;
                    $new["tax"] = $pro->tax;
                    $new["value"] = $price_sf;

                    if ($pro->tax == '0.05') {
                        $tax5++;
                    }
                    if ($pro->tax == '0.19') {
                        $tax19++;
                    }

                    DeparturesDetail::create($new);
                }

                if ($header["shipping_cost"] != 0) {
                    if ($tax19 > 0) {
                        $resp->shipping_cost_tax = 0.19;
                    } else if ($tax19 == 0 && $tax5 > 0) {
                        $resp->shipping_cost_tax = 0.05;
                    } else {
                        $resp->shipping_cost_tax = 0;
                    }
                    $resp->save();
                }

                $listdetail = $this->formatDetail($result);

                $ware = Warehouses::find($header["warehouse_id"]);

                $client = Stakeholder::find($header["client_id"]);

                $email = Email::where("description", "departures")->first();

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

                    $this->subject = "SuperFuds " . date("d/m") . " " . $client->business . " " . $cit->description . " " . $result;
                    $header["city"] = $cit->description;

                    $user = Users::find($header["responsible_id"]);

                    $header["name"] = ucwords($user->name);
                    $header["last_name"] = ucwords($user->last_name);
                    $header["phone"] = $user->phone;
                    $header["warehouse"] = $ware->description;
                    $header["address"] = $ware->address;
                    $header["detail"] = $listdetail;
                    $header["id"] = $result;
                    $header["environment"] = env("APP_ENV");
                    $header["created_at"] = $resp->created_at;

                    $this->subtotal += ($resp->shipping_cost);
                    $shipping_cost_tax = 0;

                    if ($resp->shipping_cost_tax == 0.05) {
                        $this->tax5 += $resp->shipping_cost_tax * $resp->shipping_cost;
                        $shipping_cost_tax = $this->tax5;
                    } else if ($resp->shipping_cost_tax == 0.19) {
                        $this->tax19 += $resp->shipping_cost_tax * $resp->shipping_cost;
                        $shipping_cost_tax = $this->tax19;
                    }

                    $this->total = $this->subtotal + $this->tax5 + $this->tax19 - $resp->discount;

                    $header["subtotal"] = "$" . number_format($this->subtotal, 0, ",", ".");
                    $header["total"] = "$" . number_format($this->total, 0, ",", ".");
                    $header["exento"] = $this->exento;
                    $header["tax5"] = $this->tax5;
                    $header["tax19"] = $this->tax19;
                    $header["flete"] = $resp->shipping_cost;
                    $header["discount"] = $resp->discount;
                    $header["status_id"] = $resp->status_id;

                    $this->mails[] = $user->email;

                    if ($header["environment"] == 'local') {
                        $this->mails = Auth::User()->email;
                    }

                    Mail::send("Notifications.departure", $header, function($msj) {
                        $msj->subject($this->subject);
                        $msj->to($this->mails);
                    });

                    $this->log->logClient($client->id, "Genero Orden de venta " . $result);
                }

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
    }

    public function setSale(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();

            try {
                DB::beginTransaction();

                $departure = Departures::find($input["id"]);
                $validateBriefcase = DB::table("vbriefcase")->where("client_id", $departure->client_id)->where("dias_vencidos", ">", 0)->get();

//                if ($validateBriefcase == null) {

                $val = DeparturesDetail::where("departure_id", $departure["id"])->count();
                $dep = Sales::where("departure_id", $input["id"])->get();

                if ($val > 0) {
                    $val = DeparturesDetail::where("departure_id", $departure["id"])->where("status_id", 1)->count();
                    if ($val == 0) {
                        if (count($dep) == 0) {

                            $id = DB::table("sales")->insertGetId(
                                    ["departure_id" => $departure["id"], "warehouse_id" => $departure["warehouse_id"], "responsible_id" => $departure["responsible_id"],
                                        "client_id" => $departure["client_id"], "city_id" => $departure["city_id"], "destination_id" => $departure["destination_id"],
                                        "address" => $departure["address"], "phone" => $departure["phone"], "status_id" => 2,
                                        "created" => $departure["created"], "shipping_cost" => $departure["shipping_cost"],
                                        "created_at" => date("Y-m-d H:i"), "description" => $departure["description"], "shipping_cost_tax" => $departure["shipping_cost_tax"]
                                    ]
                            );

                            $detail = DeparturesDetail::where("departure_id", $input["id"])->get();

                            $cont = 0;
                            $sale = Sales::find($id);

                            foreach ($detail as $value) {
                                if ($value->real_quantity > 0) {
                                    $pro = Products::find($value->product_id);
                                    SaleDetail::insert([
                                        "sale_id" => $id, "product_id" => $value->product_id,
                                        "category_id" => $value->category_id, "quantity" => $value->real_quantity,
                                        "value" => $value->value, "tax" => $pro["tax"], "units_sf" => $value->units_sf,
                                        "account_id" => 1, "order" => $cont, "type_nature" => 1, "packaging" => $value->packaging
                                    ]);
                                    $cont++;
                                }
                            }

                            $con = Departures::select(DB::raw("(invoice::int + 1) consecutive"))->whereNotNull("invoice")->orderBy("invoice", "desc")->first();

                            if ($departure->invoice == '') {
                                $departure->invoice = $con->consecutive;
                            }

                            $departure->status_id = 2;
                            $departure->save();

                            $detail = $this->formatDetail($input["id"]);
                            $departure = Departures::find($input["id"]);
                            $total = "$ " . number_format($this->total, 0, ",", ".");

                            $sale->dispatched = date("Y-m-d H:i:s");
                            $sale->invoice = $departure->invoice;
                            $sale->save();
                            $departure->dispatched = $sale->dispatched;
                            $departure->save();

                            //Log 
                            $this->log->logClient($departure->client_id, "Genero Factura de venta # " . $departure->invoice);

                            $cli = Stakeholder::find($departure->client_id);
                            $cli->update_at = $sale->dispatched;

                            $email = Email::where("description", "invoices")->first();

                            if ($email != null) {
                                $emDetail = EmailDetail::where("email_id", $email->id)->get();
                            }

                            if (count($emDetail) > 0 && $cont != 0) {

                                $ware = Warehouses::find($departure->warehouse_id);
                                $client = Stakeholder::find($departure->client_id);
                                $sales = Sales::where("departure_id", $departure->id)->first();
                                $this->mails = array();

                                $userware = Users::find($ware->responsible_id);
                                $this->mails[] = $userware->email;

                                foreach ($emDetail as $value) {
                                    $this->mails[] = $value->description;
                                }

                                $listdetail = $this->formatDetailSales($id);

                                $cit = Cities::find($ware->city_id);
                                $commercial = Users::where("id", $departure->responsible_id)->first();
                                $this->subject = "SuperFuds " . date("d/m") . " " . $client->business . " " . $cit->description . " " . $departure->id;
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
                                $input["dispatched"] = $sales->dispatched;
                                $input["expiration"] = date('Y-m-d', strtotime('+' . $term . ' days', strtotime($sales->dispatched)));

                                $input["responsible"] = $commercial->name . " " . $commercial->last_name;
                                $input["observation"] = $departure->description;
                                $input["city"] = $cit->description;
                                $input["detail"] = $listdetail;
                                $input["id"] = $departure->id;
                                $input["invoice"] = $departure->invoice;
                                $input["environment"] = env("APP_ENV");
                                $input["created_at"] = $departure->created_at;
                                $input["dispatched"] = $departure->dispatched;
                                $input["textTotal"] = trim($this->tool->to_word(round($this->total)));


                                $shipping_cost_tax = 0;

                                if ($departure->shipping_cost_tax == 0.05) {
                                    $this->tax5_real += $departure->shipping_cost_tax * $departure->shipping_cost;
                                    $shipping_cost_tax = $this->tax5;
                                } else if ($departure->shipping_cost_tax == 0.19) {
                                    $this->tax19_real += $departure->shipping_cost_tax * $departure->shipping_cost;
                                    $shipping_cost_tax = $this->tax19_real;
                                }

                                $this->subtotal_real += $departure->shipping_cost;
                                $this->total_real = $this->subtotal_real + $this->tax19_real + $this->tax5_real - $departure->discount;

                                $input["subtotal"] = "$" . number_format($this->subtotal_real, 0, ",", ".");
                                $input["total"] = "$" . number_format($this->total_real, 0, ",", ".");
                                $input["exento"] = "$" . number_format($this->exento, 0, ",", ".");
                                $input["tax5f"] = "$" . number_format($this->tax5_real, 0, ",", ".");
                                $input["tax5"] = $this->tax5;
                                $input["tax19f"] = "$" . number_format($this->tax19_real, 0, ",", ".");
                                $input["tax19"] = $this->tax19_real;
                                $input["flete"] = $departure->shipping_cost;
                                $input["discount"] = $departure->discount;

                                $this->mails[] = $user->email;

                                if ($input["environment"] == 'local') {
                                    $this->mails = Auth::User()->email;
                                }

                                Mail::send("Notifications.invoice", $input, function($msj) {
                                    $msj->subject($this->subject);
                                    $msj->to($this->mails);
                                });
                            } else {
                                DB::rollback();
                                return response()->json(["success" => false, "msg" => 'No hay items para facturar']);
                            }

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
//                } else {
//                    DB::rollback();
//                    return response()->json(["success" => false, "msg" => 'Facturas Pendientes por pagar'], 401);
//                }
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
        $detail = $this->formatDetail(1133);
        $subtotal = "$" . number_format($this->subtotal, 0, ",", ".");
        $total = "$" . number_format($this->total, 0, ",", ".");
        $exento = "$" . number_format($this->total, 0, ",", ".");
        $tax5f = "$" . number_format($this->tax5, 0, ",", ".");
        $tax5 = $this->tax5;
        $tax19f = "$" . number_format($this->tax19, 0, ",", ".");
        $tax19 = $this->tax19;
        $flete = 10000;
        $environment = "production";
        $discount = 0;
        $status_id = 1;
        return view("Notifications.departure", compact("name", "last_name", "id", "created_at", "detail", "warehouse", "subtotal", "total", "exento", "tax5f", "tax5", "tax19f", "tax19", "environment", "flete", "discount", "status_id"));
    }

    public function testInvoiceNotification($id) {
        $name = "jorge";
        $last_name = "Pinedo";
        $id = 1;
        $created_at = date("Y-m-d H:i");
        $warehouse = "jorge";
        $detail = $this->formatDetailSales(726);
        $subtotal = "$" . number_format($this->subtotal, 0, ",", ".");
        $total = "$" . number_format($this->total, 0, ",", ".");
        $exento = "$" . number_format($this->total, 0, ",", ".");
        $tax5f = "$ " . number_format($this->tax5, 0, ",", ".");
        $tax5 = $this->tax5;
        $tax19f = "$" . number_format($this->tax19, 0, ",", ".");
        $tax19 = $this->tax19;
        $flete = "$" . number_format(100000, 0, ",", ".");
        $environment = "production";
        $invoice = "3022";
        $flete = 0;
        $discount = 0;
        $dispatched = date("Y-m-d");

        return view("Notifications.invoice", compact("name", "last_name", "id", "created_at", "detail", "warehouse", "subtotal", "total", "exento", "tax5f", "tax5", "tax19f", "tax19", "environment", "invoice", "flete", "discount", "dispatched"));
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
        $branch = '';
        $data_branch = '';
        if ($entry->branch_id != null) {
            $branch = Branch::where("stakeholder_id", $entry->client_id)->get();
            $data_branch = Branch::find($entry->branch_id);
        }
        $total = "$ " . number_format($this->total, 0, ",", ".");
        return response()->json(["header" => $entry, "detail" => $detail, "total" => $total, "branch" => $branch, "data_branch" => $data_branch]);
    }

    public function formatDetail($id) {
        $detail = DB::table("departures_detail")->
                        select("departures_detail.id", "departures_detail.status_id", DB::raw("coalesce(departures_detail.description,'') as comment"), "departures_detail.real_quantity", "departures_detail.quantity", "departures_detail.value", DB::raw("products.reference ||' - ' ||products.title || ' - ' || stakeholder.business  as product"), "departures_detail.description", "parameters.description as status", "stakeholder.business as stakeholder", "products.bar_code", "products.units_sf", "departures_detail.tax")->join("products", "departures_detail.product_id", "products.id")
                        ->join("stakeholder", "stakeholder.id", "products.supplier_id")->join("parameters", "departures_detail.status_id", DB::raw("parameters.id and parameters.group='entry'"))->where("departure_id", $id)->orderBy("id", "asc")->get();

        $this->total = 0;
        $this->subtotal = 0;
        foreach ($detail as $i => $value) {
            $detail[$i]->valueFormated = "$" . number_format($value->value, 0, ",", ".");
            $detail[$i]->total = $detail[$i]->quantity * $detail[$i]->value * $detail[$i]->units_sf;
            $detail[$i]->total_real = $detail[$i]->real_quantity * $detail[$i]->value * $detail[$i]->units_sf;

            $detail[$i]->totalFormated = "$" . number_format($detail[$i]->total, 0, ",", ".");
            $detail[$i]->totalFormated_real = "$" . number_format($detail[$i]->total_real, 0, ",", ".");
            $this->subtotal += $detail[$i]->total;
            $this->subtotal_real += $detail[$i]->total_real;

            $this->total += $detail[$i]->total + ($detail[$i]->total * $value->tax);
            $this->total_real += $detail[$i]->total_real + ($detail[$i]->total_real * $value->tax);

            if ($value->tax == 0) {
                $this->exento += $detail[$i]->total;
                $this->exento_real += $detail[$i]->total_real;
            }
            if ($value->tax == 0.05) {
                $this->tax5 += $detail[$i]->total * $value->tax;
                $this->tax5_real += $detail[$i]->total_real * $value->tax;
            }
            if ($value->tax == 0.19) {
                $this->tax19 += $detail[$i]->total * $value->tax;
                $this->tax19_real += $detail[$i]->total_real * $value->tax;
            }
        }

        return $detail;
    }

    public function formatDetailSales($id) {
        $detail = DB::table("sales_detail")->
                        select("sales_detail.id", "sales_detail.quantity", "sales_detail.value", DB::raw("products.reference ||' - ' ||products.title || ' - ' || stakeholder.business  as product"), "sales_detail.description", "stakeholder.business as stakeholder", "products.bar_code", "products.units_sf", "sales_detail.tax")->join("products", "sales_detail.product_id", "products.id")->join("stakeholder", "stakeholder.id", "products.supplier_id")->where("sale_id", $id)->orderBy("id", "asc")->get();

        $this->total = 0;
        $this->subtotal = 0;
        foreach ($detail as $i => $value) {
            $detail[$i]->valueFormated = "$" . number_format($value->value, 2, ",", ".");
            $detail[$i]->total = $detail[$i]->quantity * $detail[$i]->value * $detail[$i]->units_sf;
            $detail[$i]->totalFormated = "$" . number_format($detail[$i]->total, 2, ",", ".");

            $this->subtotal += $detail[$i]->total;
            $this->total += $detail[$i]->total + ($detail[$i]->total * $value->tax);

            if ($value->tax == 0) {
                $this->exento += $detail[$i]->total;
            }
            if ($value->tax == 0.05) {
                $this->tax5 += $detail[$i]->total * $value->tax;
            }
            if ($value->tax == 0.19) {
                $this->tax19 += $detail[$i]->total * $value->tax;
            }
        }
        return $detail;
    }

    public function getDetail($id) {
        $detail = DeparturesDetail::FindOrFail($id);
        return response()->json($detail);
    }

    public function getAllDetail($departue_id) {
        $departure = Departures::find($departue_id);
        $detail = $this->formatDetail($departue_id);

        return response()->json(["detail" => $detail,
                    "total" => "$ " . number_format($this->total - $departure->discount, 0, ",", "."),
                    "total_real" => "$ " . number_format($this->total_real - $departure->discount, 0, ",", "."),
                    "subtotal" => "$ " . number_format($this->subtotal, 0, ",", "."),
                    "subtotal_real" => "$ " . number_format($this->subtotal_real, 0, ",", "."),
                    "tax5" => "$ " . number_format($this->tax5, 0, ",", "."),
                    "tax5_real" => "$ " . number_format($this->tax5_real, 0, ",", "."),
                    "tax19" => "$ " . number_format($this->tax19, 0, ",", "."),
                    "tax19_real" => "$ " . number_format($this->tax19_real, 0, ",", "."),
                    "exento" => "$ " . number_format($this->exento, 0, ",", "."),
                    "exento_real" => "$ " . number_format($this->exento_real, 0, ",", "."),
                    "discount" => "$ " . number_format($departure->discount, 0, ",", "."),
                    "shipping_cost" => "$ " . number_format($departure->shipping_cost, 0, ",", ".")
        ]);
    }

    public function update(Request $request, $id) {
        $entry = Departures::Find($id);
        $input = $request->all();

        unset($input["header"]["created_at"]);

        $result = $entry->fill($input["header"])->save();
        if ($result) {
            $detail = $this->formatDetail($id);
            $total = "$ " . number_format($this->total, 0, ",", ".");
            return response()->json(["header" => $entry, "detail" => $detail, "total" => $total, "success" => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function cancelInvoice(Request $request, $id) {
        $in = $request->all();
        $row = Departures::Find($id);

        $ayer = date("Y-m-d", strtotime("-1 day", strtotime(date("Y-m-d"))));


        if (strtotime($ayer) <= strtotime(date("Y-m-d", strtotime($row->dispatched))) || Auth::user()->role_id == 1) {
            $row->description = "Cancelado: " . $in["description"] . ", " . $row->description;
            $row->status_id = 4;
            $row->save();
            $resp = Departures::FindOrFail($id);
            return response()->json(['success' => true, "data" => $resp]);
        } else {
            return response()->json(['success' => false, "msg" => "Fecha de emisión supera el tiempo permitido, 1 día"], 409);
        }
    }

    public function updateDetail(Request $request, $id) {
        $input = $request->all();

        $header = Departures::find($input["departure_id"]);

        $entry = DeparturesDetail::FindOrFail($id);

        $special = PricesSpecial::where("product_id", $input["product_id"])->where("client_id", $header->client_id)->first();

        if ($special == null) {
            $pro = Products::find($input["product_id"]);
        } else {
            $pro = DB::table("products")->select("products.id", "prices_special.price_sf", "products.units_sf", 'products.tax')->join("prices_special", "prices_special.product_id", "=", "products.id")->where("products.id", $input["product_id"])->first();
        }


//        unset($input["value"]);
//        $input["value"] = $pro->price_sf;
        if (Auth::user()->role_id == 4) {
            unset($input["real_quantity"]);
            $result = $entry->fill($input)->save();
            $resp = $this->formatDetail($input["departure_id"]);
            $total = "$ " . number_format($this->total, 0, ",", ".");
            return response()->json(['success' => true, "header" => $header, "detail" => $resp, "total" => $total]);
        }


        $stock = new StockController();
        $available = $stock->getDetailProductIn($header->client_id, $input["product_id"]);
        $available = $available->getData(true);

        $input["status_id"] = 3;
//        if ($available["quantity"] == 0 && Auth::user()->role_id != 4) {
//        if (Auth::user()->role_id != 4) {
//            $input["real_quantity"] = 0;
//            $input["description"] = "Inventario no disponible, guarda 0";
//            $entry->fill($input)->save();
//            $resp = $this->formatDetail($input["departure_id"]);
//            $total = "$ " . number_format($this->total, 0, ",", ".");
//            return response()->json(['success' => true, "header" => $header, "detail" => $resp, "total" => $total, "msg" => "No se puede agregar se deja en 0"]);
//        }
//        if ($input["real_quantity"] != 0) {
//
//            if ($available["quantity"] >= $input["real_quantity"]) {
//                $result = $entry->fill($input)->save();
//                if ($result) {
//                    $resp = $this->formatDetail($input["departure_id"]);
//                    $total = "$ " . number_format($this->total, 0, ",", ".");
//                    return response()->json(['success' => true, "header" => $header, "detail" => $resp, "total" => $total]);
//                } else {
//                    return response()->json(['success' => false, "msg" => "Quantity Not available"], 409);
//                }
//            } else {
//                $available["quantity"] = ($available["quantity"] < 0) ? "0" . " Pending: " . ($available["quantity"] * -1) : $available["quantity"];
//                return response()->json(['success' => false, "msg" => "Quantity Not available, " . $available["quantity"]]);
//            }
//        } else {
//
//            $entry->fill($input)->save();
//            $resp = $this->formatDetail($input["departure_id"]);
//            $total = "$ " . number_format($this->total, 0, ",", ".");
//            return response()->json(['success' => true, "header" => $header, "detail" => $resp, "total" => $total]);
//        }

        $entry->fill($input)->save();
        $resp = $this->formatDetail($input["departure_id"]);
        $total = "$ " . number_format($this->total, 0, ",", ".");
        return response()->json(['success' => true, "header" => $header, "detail" => $resp, "total" => $total]);
    }

    public function destroy($id) {
        $row = Departures::Find($id);

        if ($row->invoice == null) {

            $detail = DeparturesDetail::where("departure_id", $row->id)->get();
            foreach ($detail as $value) {
                $det = DeparturesDetail::find($value->id);
                $det->delete();
            }
            $row->delete();

            if ($id) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false]);
            }
        } else {
            return response()->json(['success' => false, "msg" => "No se puede borrar porque este pedido fue reversado y ya tiene consecutivo"], 409);
        }
    }

    public function destroyDetail($id) {
        $entry = DeparturesDetail::FindOrFail($id);
        $result = $entry->delete();
        if ($result) {
            $header = Departures::find($entry["departure_id"]);
            $resp = $this->formatDetail($entry["departure_id"]);
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

            $header = Departures::find($input["departure_id"]);

            $special = PricesSpecial::where("product_id", $input["product_id"])->where("client_id", $header->client_id)->first();

            if ($special == null) {

                $product = Products::find($input["product_id"]);
            } else {

                $product = DB::table("products")->select("products.id", "prices_special.price_sf", "products.units_sf", 'products.tax')
                        ->join("prices_special", "prices_special.product_id", "=", "products.id")->where("products.id", $input["product_id"])
                        ->where("prices_special.client_id", $header->client_id)
                        ->first();
            }

            $input["value"] = $product->price_sf;
            $input["units_sf"] = $product->units_sf;
            $input["tax"] = $product->tax;

            $result = DeparturesDetail::create($input);
            if ($result) {
                $resp = $this->formatDetail($input["departure_id"]);
                $total = "$ " . number_format($this->total, 0, ",", ".");
                $header = Departures::find($input["departure_id"]);
                return response()->json(['success' => true, "header" => $header, "detail" => $resp, "total" => $total]);
            } else {
                return response()->json(['success' => false]);
            }
        }
    }

    public function generateRemission($id) {
        $row = Departures::find($id);
        $con = Departures::select(DB::raw("count(*) +1 consecutive"))->whereNotNull("remission")->first();
        $row->status_id = 5;
        $row->remission = $con->consecutive;
        $row->save();
        return response()->json(['success' => true]);
    }

    public function generateInvoice($id) {
        $sale = Sales::where("departure_id", $id)->first();

        $dep = Departures::find($id)->toArray();


        $detail = DB::table("sales_detail")->select("quantity", DB::raw("sales_detail.tax * 100 as tax"), DB::raw("coalesce(sales_detail.description,'') as description"), "products.title as product", "products.id as product_id", "sales_detail.value", "sales_detail.units_sf", DB::raw("sales_detail.units_sf * sales_detail.quantity as quantityTotal"), DB::raw("sales_detail.value * sales_detail.quantity * sales_detail.units_sf as valueTotal"), "stakeholder.business as stakeholder")->join("products", "sales_detail.product_id", "products.id")->join("stakeholder", "products.supplier_id", "stakeholder.id")->where("sale_id", $sale["id"])->orderBy("order", "asc")->get();

        $cli = Stakeholder::select("stakeholder.id", "stakeholder.business_name", "stakeholder.document", "stakeholder.address_invoice", "cities.description as city", "stakeholder.term")->where("stakeholder.id", $sale["client_id"])->join("cities", "cities.id", "stakeholder.city_id")->first();

        $user = Users::find($dep["responsible_id"]);
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

        $ware = Warehouses::find($dep["warehouse_id"]);

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
            $this->subject = "SuperFuds " . date("d/m") . " " . $cli->business . " " . $cit->description . " Despacho de Pedido, factura " . $dep["invoice"];
            $input["city"] = $cit->description;
            $input["consecutive"] = $dep["id"];
            $input["invoice"] = $dep["invoice"];

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
