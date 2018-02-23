<?php

namespace App\Http\Controllers\Crm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\Models\Seller\Fulfillment;
use App\Models\Seller\FulfillmentDetail;
use App\Models\Administration\Stakeholder;
use App\Models\Inventory\Departures;
use App\Models\Inventory\DeparturesDetail;
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
        return view("crm.fulfillment.init", compact("meses"));
    }

    public function getInfo($year, $month) {
        $data = Fulfillment::where("year", $year)->where("month", $month)->first();

        if (count($data) == 0) {
            return response()->json(["response" => false]);
        } else {
            $data["valueFormated"] = "$ " . number_format($data["value"], 2, ",", ".");
            $res = DB::select("select sum(quantity*value) as total from departures_detail WHERE created_at between '" . $year . "-" . $month . "-01 00:00' and '2017-03-31 23:59'");
            $data["valueFormatedPending"] = number_format((100 * $res[0]->total) / $data["value"], 2, ".", ",");
            $detail = $this->dataDetail($data["id"]);
            return response()->json(["response" => true, "data" => $data, "detail" => $detail]);
        }
    }

    public function getSales($user_id) {
        $stake = Stakeholder::where("responsible_id", $user_id)->get();

        foreach ($stake as $value) {
            $dep = Departures::where("client_id", $value->id)->get();
            foreach ($dep as $val) {
                $resp[] = DeparturesDetail::where("departure_id", $val->id)->get();
            }
        }

        return $resp;
    }

    public function getMax($id) {
        $header = Fulfillment::findOrFail($id);
        $total = FulfillmentDetail::where("fulfillment_id", $id)->sum("value");
        $format = "$ " . number_format($header["value"] - $total, 2, ",", ".");
        return response()->json(["response" => true, "max" => $format]);
    }

    public function dataDetail($id) {
        $detail = DB::table("fulfillment_detail")
                        ->select("fulfillment_detail.value", "users.name", "users.last_name", "users.id as user_id", "fulfillment_detail.id")
                        ->join("users", "users.id", "fulfillment_detail.commercial_id")
                        ->where("fulfillment_id", $id)->get();


        foreach ($detail as $i => $value) {
            if ($value->value != 0) {
                $detail[$i]->progress = number_format(((100 * $this->getValueDetail($value->user_id))) / $value->value, 2, ".", ",");
            } else {
                $detail[$i]->progress = 0;
            }

            $detail[$i]->valueTotal = $this->getValueDetail($value->user_id);
            $detail[$i]->valueTotalFormated = "$ " . number_format($this->getValueDetail($value->user_id), 2, ",", ".");
            $detail[$i]->tarjet = $value->value;
            $detail[$i]->value = "$ " . number_format($value->value, 2, ",", ".");
        }

        return $detail;
    }

    public function getValueDetail($id) {
        $stake = Stakeholder::where("responsible_id", $id)->get();

        $quantity = 0;
        foreach ($stake as $value) {
            $dep = Departures::where("client_id", $value->id)->get();

            foreach ($dep as $val) {
                $res = DB::select("select sum(quantity*value) as total from departures_detail where departure_id=" . $val->id);
                $quantity += (float) str_replace(".", ",", $res[0]->total);
            }
        }

        return $quantity;
    }

    public function setTarjet(Request $req) {
        $input = $req->all();
        unset($input["id"]);
        $id = Fulfillment::create($input)->id;
        $input["id"] = $id;
        $input["valueFormated"] = "$ " . number_format($input["value"], 2, ",", ".");
        return response()->json(["success" => true, "data" => $input]);
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);
//            $user = Auth::User();
//            $input["users_id"] = 1;
            $val = FulfillmentDetail::where("fulfillment_id", $input["fulfillment_id"])->where("commercial_id", $input["commercial_id"])->get();
            
            if (count($val) == 0) {
                $val = Fulfillment::findOrFail($input["fulfillment_id"]);
                $det = FulfillmentDetail::where("fulfillment_id", $input["fulfillment_id"])->sum("value");
                $max = $val["value"] - $det;

                if ($max >= $input["value"]) {
                    $result = FulfillmentDetail::create($input);
                    if ($result) {
                        $detail = $this->dataDetail($input["fulfillment_id"]);
                        return response()->json(['success' => true, "detail" => $detail]);
                    } else {
                        return response()->json(['success' => false], 409);
                    }
                } else {
                    $number = "$ " . number_format($max, 2, ",", ".");
                    return response()->json(['success' => false, "msg" => "The value must be less than " . $number], 409);
                }
            } else {
                return response()->json(['success' => false, "msg" => "Commercial already exist"], 409);
            }
        }
    }

    public function edit($id) {
        $suppliers = Categories::FindOrFail($id);
        return response()->json($suppliers);
    }

    public function update(Request $request, $id) {
        $record = Fulfillment::FindOrFail($id);
        $input = $request->all();
        $result = $record->fill($input)->save();
        if ($result) {
            $response = Fulfillment::FindOrFail($id);
            $response["valueFormated"] = "$ " . number_format($response["value"], 2, ",", ".");
            return response()->json(['success' => true, "data" => $response]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function updateDetail(Request $request, $id) {
        $record = FulfillmentDetail::FindOrFail($id);
        $input = $request->all();
        $result = $record->fill($input)->save();
        if ($result) {
            $data = $this->dataDetail($record["fulfillment_id"]);
            return response()->json(['success' => true, "detail" => $data]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function getDetail($id) {
        $record = FulfillmentDetail::FindOrFail($id);
        if ($record) {
            return response()->json(['success' => true, "data" => $record]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function destroy($id) {
        $category = Categories::FindOrFail($id);
        $result = $category->delete();
        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

}
