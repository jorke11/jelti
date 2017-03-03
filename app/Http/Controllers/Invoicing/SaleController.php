<?php

namespace App\Http\Controllers\Invoicing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Invoicing\Sale;
use App\Models\Invoicing\SaleDetail;
use \Illuminate\Support\Facades\DB;
use Session;

class SaleController extends Controller {

    public function index() {
        return view("sale.init");
    }

    public function getConsecutive($id) {
        echo response()->json(["response" => 'prueba']);
    }

    public function getQuantity($id) {
        $product = \App\Models\Invoicing\PurchageDetail::where("product_id", $id)->first();
        return response()->json(["response" => $product]);
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);
//            $user = Auth::User();
            $input["city_id"] = 1;
            $result = Sale::create($input);
            if ($result) {
                Session::flash('save', 'Se ha creado correctamente');
                $resp = Sale::FindOrFail($result["attributes"]["id"]);
                return response()->json(['success' => 'true', "data" => $resp]);
            } else {
                return response()->json(['success' => 'false']);
            }
        }
    }

    public function edit($id) {
        $entry = Sale::FindOrFail($id);
        $detail = DB::table("saledetail")->where("sale_id", "=", $id)->get();
        return response()->json(["header" => $entry, "detail" => $detail]);
    }

    public function getDetail($id) {
        $detail = SaleDetail::FindOrFail($id);
        return response()->json($detail);
    }

    public function update(Request $request, $id) {
        $entry = Sale::FindOrFail($id);
        $input = $request->all();
        $result = $entry->fill($input)->save();
        if ($result) {
            $resp = Sale::FindOrFail($id);
            Session::flash('save', 'Se ha creado correctamente');
            return response()->json(['success' => 'true', "data" => $resp]);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

    public function updateDetail(Request $request, $id) {
        $entry = SaleDetail::FindOrFail($id);
        $input = $request->all();
        $result = $entry->fill($input)->save();
        if ($result) {
            $resp = DB::table("saledetail")->where("sale_id", "=", $input["sale_id"])->get();
            Session::flash('save', 'Se ha creado correctamente');
            return response()->json(['success' => 'true', "data" => $resp]);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

    public function destroy($id) {
        $entry = Sale::FindOrFail($id);
        $result = $entry->delete();
        Session::flash('delete', 'Se ha eliminado correctamente');
        if ($result) {
            Session::flash('save', 'Se ha creado correctamente');
            return response()->json(['success' => 'true']);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

    public function destroyDetail($id) {
        $entry = SaleDetail::FindOrFail($id);
        $result = $entry->delete();
        Session::flash('delete', 'Se ha eliminado correctamente');
        if ($result) {
            $resp = DB::table("saledetail")->where("sale_id", "=", $entry["sale_id"])->get();
            Session::flash('save', 'Se ha creado correctamente');
            return response()->json(['success' => 'true', "data" => $resp]);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

    public function storeDetail(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);
//            $user = Auth::User();
//            $input["users_id"] = 1;
            $result = SaleDetail::create($input);
            if ($result) {
                Session::flash('save', 'Se ha creado correctamente');
                $resp = SaleDetail::where("sale_id",$input["sale_id"])->get();
                return response()->json(['success' => 'true', "data" => $resp]);
            } else {
                return response()->json(['success' => 'false']);
            }
        }
    }

}
