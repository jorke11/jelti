<?php

namespace App\Http\Controllers\Sales;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Parameters;
use App\Models\Inventory\Departures;
use App\Models\Sales\BriefCase;
use DB;
use Datatables;

class BriefcaseController extends Controller {

    public $name;
    public $path;

    public function __construct() {
        $this->middleware("auth");
        $this->name = '';
        $this->path = '';
    }

    public function index() {
        $category = \App\Models\Administration\Categories::all();
        $status = Parameters::where("group", "departure")->get();
        return view("Sales.Briefcase.init", compact("category", "status"));
    }

    public function getList() {
        $query = DB::table("vbriefcase")
                ->orderBy("id", "asc");
        return Datatables::queryBuilder($query)->make(true);
    }

    public function getBriefcase(Request $req) {
        $input = $req->all();
        $departures = explode(",", $input["departures"]);
        $dep = BriefCase::select("briefcase.id", "departures.invoice", "briefcase.value", "briefcase.created_at", DB::raw("briefcase.value::money as valuepayed"))
                ->join("departures", "departures.id", "briefcase.departure_id")
                ->whereIn("briefcase.departure_id", $departures)
                ->orderBy("departures.invoice")
                ->get();

        $resp = array();
        $cont = 0;
        $total = 0;

        foreach ($dep as $i => $value) {
            if ($i > 0) {
                if ($dep[$i]->invoice != $dep[$i - 1]->invoice) {
                    $resp[$cont][] = array("total" => $total, "totalformated" => "$ " . number_format($total, 0, ",", "."));
                    $total = 0;
                    $cont++;
                }
            }
            $total += $value->value;
            $resp[$cont][] = array("id" => $value->id, "invoice" => $value->invoice, "value" => $value->value, "created_at" => date("Y-m-d H:i", strtotime($value->created_at)), "valuepayed" => $value->valuepayed);
            if ($i == (count($dep) - 1)) {
                $resp[$cont][] = array("total" => $total, "totalformated" => "$ " . number_format($total, 0, ",", "."));
            }
        }

        return response()->json(["success" => true, "data" => $resp]);
    }
    
    public function formatDetail($dep){
        
    }

    public function storePayment(Request $req) {
        $input = $req->all();
        $departures = $input["invoices"];
        $values = $input["values"];

        $this->name = '';
        $this->path = '';
        $file = array_get($input, 'document_file');

        if ($file) {
            $this->name = $file->getClientOriginalName();
            $this->name = str_replace(" ", "_", $this->name);
            $this->path = "uploads/invoice/" . date("Y-m-d") . "/" . $this->name;
            $file->move("uploads/invoice/" . date("Y-m-d") . "/", $this->name);
        }

        foreach ($departures as $i => $value) {
            $new["departure_id"] = $value;
            $new["value"] = $values[$i];
            if ($file) {
                $new["img"] = $this->path;
            }
            BriefCase::create($new);
        }

        $response = BriefCase::whereIn("id", $departures)->get();
        return response()->json(["success" => true, "data" => $response]);
    }

}
