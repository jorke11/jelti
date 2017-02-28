<?php

namespace App\Http\Controllers\Invoicing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Illuminate\Support\Facades\DB;
use App\Models\Administration\Warehouses;
use App\Models\Invoicing\Purchases;
use App\Models\Invoicing\PurchasesDetail;
use Illuminate\Support\Facades\Auth;

class PurchageController extends Controller {

    public function index() {
        $responsable = DB::select('select id,name from users');
        $warehouse = Warehouses::all();
        $product = \App\Models\Administration\Products::all();
        $city = \App\Models\Administration\Cities::all();
        $mark = \App\Models\Administration\Mark::all();
        $supplier = \App\Models\Administration\Suppliers::all();
        $category = \App\Models\Administration\Categories::all();
        return view("purchage.init", compact("responsable", "warehouse", "supplier", "product", "mark", "category","city"));
    }

    public function getConsecutive($id) {
        echo response()->json(["response" => 'prueba']);
    }
    public function getSupplier($id) {
        $supplier=\App\Models\Administration\Suppliers::findOrFail($id);
        return response()->json(["response" => $supplier]);
    }
    public function getProducts($id) {
        $resp = \App\Models\Administration\Products::where("supplier_id",$id);
        return response()->json(["response" => $resp]);
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);
//            $user = Auth::User();
//            $input["users_id"] = 1;
            $result = Purchases::create($input);
            if ($result) {
                Session::flash('save', 'Se ha creado correctamente');
                $resp = Purchases::FindOrFail($result["attributes"]["id"]);
                return response()->json(['success' => 'true', "data" => $resp]);
            } else {
                return response()->json(['success' => 'false']);
            }
        }
    }

    public function edit($id) {
        $entry = Purchases::FindOrFail($id);
        $detail = DB::table("purchases_detail")->where("purchase_id", "=", $id)->orderBy('order', 'ASC')->get();
        return response()->json(["header" => $entry, "detail" => $detail]);
    }

    public function getDetail($id) {
        $detail = PurchasesDetail::FindOrFail($id);
        return response()->json($detail);
    }

    public function update(Request $request, $id) {
        $entry = Purchases::FindOrFail($id);
        $input = $request->all();
        $result = $entry->fill($input)->save();
        if ($result) {
            $resp = Purchases::FindOrFail($id);
            Session::flash('save', 'Se ha creado correctamente');
            return response()->json(['success' => 'true', "data" => $resp]);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

    public function updateDetail(Request $request, $id) {
        $entry = PurchasesDetail::FindOrFail($id);
        $input = $request->all();
        $result = $entry->fill($input)->save();
        if ($result) {
            $resp = DB::table("purchagedetail")->where("purchage_id", "=", $input["entry_id"])->get();
            Session::flash('save', 'Se ha creado correctamente');
            return response()->json(['success' => 'true', "data" => $resp]);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

    public function destroy($id) {
        $entry = Purchases::FindOrFail($id);
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
        $entry = PurchageDetail::FindOrFail($id);
        $result = $entry->delete();
        Session::flash('delete', 'Se ha eliminado correctamente');
        if ($result) {
            $resp = DB::table("purchagedetail")->where("purchage_id", "=", $entry["purchage_id"])->get();
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
            $result = PurchageDetail::create($input);
            if ($result) {
                Session::flash('save', 'Se ha creado correctamente');
                $resp = PurchageDetail::where("purchage_id", $input["purchage_id"])->get();
                return response()->json(['success' => 'true', "data" => $resp]);
            } else {
                return response()->json(['success' => 'false']);
            }
        }
    }

}
