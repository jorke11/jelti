<?php

namespace App\Http\Controllers\Sales;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Categories;
use App\Models\Administration\Parameters;
use App\Models\Inventory\Departures;
use App\Models\Sales\CreditNote;
use DB;

class creditnoteController extends Controller {

    protected $total;
    public $total_real;
    public $path;
    public $name;
    public $listProducts;
    public $errors;

    public function __construct() {
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

        
        
        foreach ($input["detail"] as $value) {
            $cre = new CreditNote();
            $cre->departure_id = $input["header"]["id"];
            $cre->item_id = $value["id"];
            $cre->quantity = $value["quantity"];
            $cre->save();
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

}
