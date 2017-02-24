<?php

namespace App\Http\Controllers\Invoicing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Illuminate\Support\Facades\DB;
use App\Models\Administration\Warehouse;
use App\Models\Invoicing\Purchage;
use App\Models\Invoicing\PurchageDetail;
use Illuminate\Support\Facades\Auth;

class PurchageController extends Controller {

    public function index() {
        $responsable = DB::select('select id,name from users');
        $warehouse = Warehouse::all();
        $product = \App\Models\Administration\Product::all();
        $city = \App\Models\Administration\City::all();
        $mark = \App\Models\Administration\Mark::all();
        $supplier = \App\Models\Administration\Supplier::all();
        $category = \App\Models\Administration\Category::all();
        return view("purchage.init", compact("responsable", "warehouse", "supplier", "product", "mark", "category","city"));
    }

    public function getConsecutive($id) {
        echo response()->json(["response" => 'prueba']);
    }
    public function getSupplier($id) {
        $supplier=\App\Models\Administration\Supplier::findOrFail($id);
        return response()->json(["response" => $supplier]);
    }
    public function getProducts($id) {
        $resp = \App\Models\Administration\Product::where("supplier_id",$id);
        return response()->json(["response" => $resp]);
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);
//            $user = Auth::User();
//            $input["users_id"] = 1;
            $result = Purchage::create($input);
            if ($result) {
                Session::flash('save', 'Se ha creado correctamente');
                $resp = Purchage::FindOrFail($result["attributes"]["id"]);
                return response()->json(['success' => 'true', "data" => $resp]);
            } else {
                return response()->json(['success' => 'false']);
            }
        }
    }
    
    

    public function edit($id) {
        $entry = Purchage::FindOrFail($id);
        $detail = DB::table("purchage_detail")->where("purchage_id", "=", $id)->get();
        return response()->json(["header" => $entry, "detail" => $detail]);
    }

    public function getDetail($id) {
        $detail = PurchageDetail::FindOrFail($id);
        return response()->json($detail);
    }

    public function update(Request $request, $id) {
        $entry = Purchage::FindOrFail($id);
        $input = $request->all();
        $result = $entry->fill($input)->save();
        if ($result) {
            $resp = Purchage::FindOrFail($id);
            Session::flash('save', 'Se ha creado correctamente');
            return response()->json(['success' => 'true', "data" => $resp]);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

    public function updateDetail(Request $request, $id) {
        $entry = PurchageDetail::FindOrFail($id);
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
        $entry = Purchage::FindOrFail($id);
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
