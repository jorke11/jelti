<?php

namespace App\Http\Controllers\Sales;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Categories;
use App\Models\Administration\Parameters;
use App\Models\Administration\Stakeholder;
use App\Models\Administration\Warehouses;
use App\Models\Security\Users;
use App\Models\Inventory\Departures;
use App\Models\Invoicing\Sales;
use App\Models\Invoicing\SaleDetail;
use App\Models\Sales\CreditNote;
use App\Models\Sales\CreditNoteDetail;
use App\Http\Controllers\ToolController;
use DB;

class creditnoteController extends Controller {

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
        $category = Categories::all();
        $status = Parameters::where("group", "departure")->get();
        return view("Sales.CreditNote.init", compact("category", "status"));
    }

    public function edit($id) {
        $entry = Departures::FindOrFail($id);
        $detail = $this->formatDetail($id);

        return response()->json(["header" => $entry, "detail" => $detail]);
    }

    public function store(Request $req) {
        $input = $req->all();

        $sales = Sales::where("departure_id", $input["header"]["id"])->first();
        $new["sale_id"] = $sales->id;
        $new["departure_id"] = $input["header"]["id"];

        $id = CreditNote::create($new)->id;

        foreach ($input["detail"] as $value) {
            if ($value["quantity"] != 0) {
                $cre = new CreditNoteDetail();
                $cre->creditnote_id = $id;
                $cre->row_id = $value["id"];
                $cre->quantity = $value["quantity"];
                $cre->product_id = $value["product_id"];
                $cre->save();
            }
        }

        return response()->json(["success" => true]);
    }

    public function formatDetail($id) {

        $detail = DB::table("departures_detail")
                ->select("departures_detail.id", "departures_detail.status_id", DB::raw("coalesce(departures_detail.description,'') as comment"), "departures_detail.real_quantity", "departures_detail.quantity", "departures_detail.value", DB::raw("products.reference ||' - ' ||products.title as product"), "departures_detail.description", "parameters.description as status", "stakeholder.business as stakeholder", "products.bar_code", "products.units_sf", "products.id as product_id")
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

    public function getInvoice($id) {
        $this->mails = array();

        $sale = Sales::where("departure_id", $id)->first();
        $detail = DB::table("sales_detail")
                ->select(DB::raw("credit_note_detail.quantity as quantity"), DB::raw("sales_detail.tax * 100 as tax"), 
                        DB::raw("coalesce(sales_detail.description,'') as description"), "products.title as product", "products.id as product_id", 
                        "sales_detail.value", "sales_detail.units_sf", DB::raw("sales_detail.units_sf * sales_detail.quantity as quantityTotal"), 
                        DB::raw("sales_detail.value * (credit_note_detail.quantity) * sales_detail.units_sf as valueTotal"), 
                        "stakeholder.business as stakeholder")
                ->join("products", "sales_detail.product_id", "products.id")
                ->join("stakeholder", "products.supplier_id", "stakeholder.id")
                ->join("credit_note_detail", "credit_note_detail.product_id", "sales_detail.product_id")
                ->where("sale_id", $sale["id"])
                ->orderBy("order", "asc")
                ->get();

        $dep = Departures::find($id);

        $cli = Stakeholder::select("stakeholder.id", "stakeholder.business_name", "stakeholder.document", "stakeholder.address_invoice", "cities.description as city", "stakeholder.term")
                ->where("stakeholder.id", $sale["client_id"])
                ->join("cities", "cities.id", "stakeholder.city_id")
                ->first();
        $user = Users::find($dep["responsible_id"]);

        $ware = Warehouses::find($dep["warehouse_id"]);

        $this->email[] = $user->email;


        $term = 7;

        if ($cli["term"] != null) {
            $term = $cli["term"];
        }

        $expiration = date('Y-m-d', strtotime('+' . $term . ' days', strtotime($sale["created"])));

        $cli["address_invoice"] = $sale["address"];
        $cli["emition"] = $this->formatDate($sale["created"]);
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

        $rete = SaleDetail::where("description", "rete")->where("sale_id", $sale["id"])->first();

//        $totalWithTax = $totalSum + $totalTax19 + $totalTax5 + $dep->shipping_cost - ($rete["value"]);
        $totalWithTax = $totalSum + $totalTax19 + $totalTax5 + $dep->shipping_cost;

        $tool = new ToolController();

        $cli["business_name"] = $tool->cleanText($cli["business_name"]);


        $credit = CreditNote::where("departure_id", $id)->first();

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
            'invoice' => $credit->id,
            'textTotal' => trim($tool->to_word(round($totalWithTax)))
        ];




        $pdf = \PDF::loadView('Inventory.departure.pdfcredit', [], $data, [
                    'title' => 'Invoice']);
//  
        header('Content-Type: application/pdf');
//        return $pdf->download('factura_' . $dep["invoice"] . '_' . $cli["business_name"] . '.pdf');
        return $pdf->stream('nota_credito_' . $dep["invoice"] . '_' . $cli["business_name"] . '.pdf');
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

}
