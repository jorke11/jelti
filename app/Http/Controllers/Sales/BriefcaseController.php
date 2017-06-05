<?php

namespace App\Http\Controllers\Sales;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Parameters;
use App\Models\Inventory\Departures;
use DB;
use Datatables;

class BriefcaseController extends Controller {

    public $name;
    public $path;

    public function __construct() {
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
//                ->where("client_id", $id)
                ->orderBy("id", "asc");

        return Datatables::queryBuilder($query)->make(true);
    }

    public function storePayment(Request $req) {
        $input = $req->all();
        $invoices = $input["invoices"];

        $this->name = '';
        $this->path = '';
        $file = array_get($input, 'document_file');
        $this->name = $file->getClientOriginalName();
        $this->name = str_replace(" ", "_", $this->name);
        $this->path = "uploads/invoice/" . date("Y-m-d") . "/" . $this->name;
        $file->move("uploads/invoice/" . date("Y-m-d") . "/", $this->name);

        foreach ($invoices as $value) {
            $dep = Departures::find($value);
            $dep->voucher = $this->path;
            $dep->paid_out = true;
            $dep->save();
        }

        return response()->json(["success" => true]);
    }

}
