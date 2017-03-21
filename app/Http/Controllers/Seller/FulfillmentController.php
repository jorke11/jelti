<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\Models\Seller\Fulfillment;
use App\Models\Seller\FulfillmentDetail;
use DB;

class FulfillmentController extends Controller {

    public function __construct() {
        $this->middleware("auth");
    }

    public function index() {
        $meses = array(
            '01' => 'enero',
            '02' => 'febrero', '03' => 'marzo', '04' => 'abril', '05' => 'mayo', '06' => 'junio', '07' => 'julio',
            '08' => 'agosto', '09' => 'septiembre', '10' => 'octubre', '11' => 'noviembre', '12' => 'diciembre');
        return view("Sellers.fulfillment.init", compact("meses"));
    }

    public function getInfo($year, $month) {
        $data = Fulfillment::where("year", $year)->where("month", $month)->first();

        if (count($data) == 0) {
            return response()->json(["response" => false]);
        } else {
            $data["valueFormated"] = "$ " . number_format($data["value"], 2, ",", ".");

            $detail = DB::table("fulfillment_detail")
                            ->select("fulfillment_detail.value", "users.name", "users.last_name", "fulfillment_detail.id")
                            ->join("users", "users.id", "fulfillment_detail.commercial_id")
                            ->where("fulfillment_id", $data["id"])->get();

            foreach ($detail as $i => $value) {
                $detail[$i]->progress = 50;
                $detail[$i]->tarjet = 100;
            }

            return response()->json(["response" => true, "data" => $data, "detail" => $detail]);
        }
    }

    public function dataDetail() {
        
    }

    public function setTarjet(Request $req) {
        $input = $req->all();
        unset($input["id"]);
        $id = Fulfillment::create($input)->id;
        $input["id"] = $id;
        $input["valueFormated"] = "$ " . number_format($input["value"], 2, ",", ".");
        return response()->json(["response" => true, "data" => $input]);
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);
//            $user = Auth::User();
//            $input["users_id"] = 1;

            $result = FulfillmentDetail::create($input);
            if ($result) {
                Session::flash('save', 'Se ha creado correctamente');
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false]);
            }
        }
    }

    public function edit($id) {
        $suppliers = Categories::FindOrFail($id);
        return response()->json($suppliers);
    }

    public function update(Request $request, $id) {
        $category = Categories::FindOrFail($id);
        $input = $request->all();
        $result = $category->fill($input)->save();
        if ($result) {
            return response()->json(['success' => 'true']);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

    public function destroy($id) {
        $category = Categories::FindOrFail($id);
        $result = $category->delete();
        if ($result) {
            return response()->json(['success' => 'true']);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

}
