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
use App\Models\Administration\Products;
use App\Http\Controllers\ToolController;
use DB;
use Datatables;
use App\Traits\NumberToString;
use App\Traits\StringExtra;
use App\Traits\ToolInventory;
use App\Traits\Invoice;
use App\Models\Inventory\DeparturesDetail;

class creditnoteController extends Controller {

    use NumberToString;
    use StringExtra;
    use ToolInventory;
    use Invoice;

    public $path;
    public $name;
    public $listProducts;
    public $errors;
    public $objDep;

    public function __construct() {
        $this->middleware("auth");
        $this->total = 0;
        $this->total_real = 0;
        $this->path = '';
        $this->name = '';
        $this->listProducts = array();
        $this->errors = array();

        $this->objDep = new \App\Http\Controllers\Sales\DepartureController();
    }

    public function index() {
        $category = Categories::all();
        $status = Parameters::where("group", "departure")->get();
        return view("Sales.CreditNote.init", compact("category", "status"));
    }

    public function edit($id) {
        $entry = Sales::where("departure_id", $id)->first();
        $departure = Departures::find($id);
        $detail = $this->formatDetailCredit($id);

        return response()->json(["header" => $departure, "detail" => $detail]);
    }

    public function getDetailDeparture($id) {

        $sale = Sales::where("departure_id", $id)->first();
        $departure = Departures::find($id);
        $detail = $this->formatDetail($id, true);

        return response()->json(["header" => $departure, "detail" => $detail]);
    }

    public function store(Request $req) {
        $input = $req->all();

        try {
            $error = [];
            DB::beginTransaction();
//            dd($input);
            $sales = Sales::where("departure_id", $input["id"])->first();

            $dep = Departures::find($input["id"]);

            $new["sale_id"] = $sales->id;
            $new["departure_id"] = $input["id"];
            $new["description"] = $input["description"];
            if (count($input["detail"]) > 0) {
                $id = CreditNote::create($new)->id;
                $valquantity = 0;
                foreach ($input["detail"] as $value) {
                    if (isset($value["quantity"]) && $value["quantity"] != 0) {

                        $row_det = DeparturesDetail::find($value["id"]);
                        $row_cre = CreditNoteDetail::where("row_id", $value["id"])->sum("quantity");

                        if ($row_cre != null) {
                            $valquantity = $value["quantity"] + $row_cre;
                        }

                        

                        if ((int) $row_det->real_quantity <= (int) $valquantity) {
                            echo ((int) $row_det->real_quantity <= (int) $valquantity);
                            echo $row_det->real_quantity . " - " . $valquantity;exit;
                            $error[] = array("msg" => "La cantidad solicitudad", "produc" => $value["product"], "cant_sol" => $value["quantity"], "disponible" => $row_det->real_quantity);
                        }

                        $cre = new CreditNoteDetail();
                        $cre->creditnote_id = $id;
                        $cre->row_id = $value["id"];
                        $cre->quantity = $value["quantity"];
                        $cre->product_id = $value["product_id"];
                        $cre->save();

                        if ($value["type_credit_note"] == 1) {
                            $pro = Products::find($value["product_id"]);
                            $this->addInventory($dep->warehouse_id, $pro->reference, $value["quantity"], $value["lot"], $value["expiration_date"], $value["cost_sf"], $value["price_sf"], "note_to_inv");
                        }
                    }
                }

                if (count($error) > 0) {
                    DB::rollback();
                    return response()->json(["success" => false, "msg" => "Problemas con la petición, por la cantidad solicitada!", "error" => $error], 500);
                } else {
                    $dep->credinote_id = $id;
                    $this->objDep->sendNofication($dep, 'credit_note');
                    DB::commit();
                    return response()->json(["success" => true]);
                }
            } else {
                return response()->json(["success" => false, "msg" => "Detalle debe contener información!"], 500);
            }
        } catch (Exception $exc) {
            DB::rollback();
            return response()->json(["success" => false, "msg" => "Problemas con la ejecucion, por favor revise!"], 500);
        }
    }

    public function editCreditNote($id) {
        $res = CreditNoteDetail::select("credit_note_detail.id", "products.title as product", "credit_note_detail.quantity")
                        ->join("products", "products.id", "credit_note_detail.product_id")
                        ->where("creditnote_id", $id)->get();
        return response()->json(["success" => true, "detail" => $res]);
    }

    public function formatDetailCredit($id) {
        $sale = Sales::where("departure_id", $id)->first();
        $credit = CreditNote::where("departure_id", $id)->first();
        $detail = [];

        if ($credit != null) {
            $detail = CreditNoteDetail::select("credit_note_detail.id", "credit_note_detail.quantity", "products.title as product"
                            , "departures_detail.value", "departures_detail.real_quantity")
                    ->join("products", "products.id", "credit_note_detail.product_id")
                    ->join("credit_note", "credit_note.id", "credit_note_detail.creditnote_id")
                    ->join("vdepartures", "vdepartures.id", "credit_note.departure_id")
                    ->join("departures_detail", "departures_detail.departure_id", DB::raw("credit_note.departure_id and departures_detail.product_id=credit_note_detail.product_id"))
                    ->where("credit_note_detail.creditnote_id", $credit->id)
                    ->get();
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
        }
        return $detail;
    }

    public function getInvoice($id) {
        $this->mails = array();

        $cre = CreditNote::find($id);

        $sale = Sales::where("departure_id", $cre->departure_id)->first();

//        dd($cre->id);
        $detail = DB::table("vcreditnote_detail_row")
                ->select("id", "quantity", "tax", "product", "product_id", "value", "units_sf", "stakeholder", "quantitytotal", "valuetotal")
                ->whereNotNull("product_id")
                ->where("id", $cre->id)
                ->get();

//        dd($detail);

        $dep = Departures::find($cre->departure_id);

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

        $expiration = date('Y-m-d', strtotime('+' . $term . ' days', strtotime($cre["created_at"])));

        $cli["address_invoice"] = $sale["address"];
        $cli["emition"] = $this->formatDate($cre["created_at"]);
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
            $tax = $value->tax;

            if ($value->tax == 0) {
                $totalExemp += $value->valuetotal;
            }
            if ($value->tax == 0.05) {
                $totalTax5 += $value->valuetotal * $tax;
            }
            if ($value->tax == 0.19) {

                $totalTax19 += $value->valuetotal * $tax;
            }
        }

        $rete = SaleDetail::where("description", "rete")->where("sale_id", $sale["id"])->first();

//        $totalWithTax = $totalSum + $totalTax19 + $totalTax5 + $dep->shipping_cost - ($rete["value"]);
        $totalWithTax = $totalSum + $totalTax19 + $totalTax5;

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
            'shipping' => "$ " . 0,
            'invoice' => $cre->id,
            'textTotal' => trim($this->to_word(round($totalWithTax)))
        ];
        $pdf = \PDF::loadView('Sales.CreditNote.pdfcredit', [], $data, [
                    'title' => 'Invoice']);
//  
        header('Content-Type: application/pdf');
//        return $pdf->download('factura_' . $dep["invoice"] . '_' . $cli["business_name"] . '.pdf');
        return $pdf->stream('nota_credito_' . $dep["invoice"] . '_' . $cli["business_name"] . '.pdf');
    }

    public function editCreditNotePDF(Request $req) {
        $in = $req->all();
        $query = DB::table('vcreditnote_detail');
        $query->where("departure_id", $in["departure_id"]);

        return Datatables::queryBuilder($query)->make(true);
    }

    public function delete($id) {
        try {
            DB::beginTransaction();
            $row = CreditNote::find($id);
            $detail = CreditNoteDetail::where("creditnote_id", $id)->get();

            $row->delete();

            foreach ($detail as $value) {
                $record = CreditNoteDetail::find($value->id);
                $record->delete();
            }

            DB::commit();

            return response()->json(['success' => true]);
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(['success' => false, "msg" => "Wrong"], 409);
        }
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
