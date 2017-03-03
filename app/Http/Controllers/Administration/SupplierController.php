<?php

namespace App\Http\Controllers\Administration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration;
use App\Models\Core;
use Session;
use App\Models\Administration\Suppliers;
use App\Models\Administration\PricesSpecial;
use App\Models\Administration\Branch;
use Datatables;

class SupplierController extends Controller {

    public function index() {
        $type_person = Administration\TypePersons::all();
        $type_regimen = Administration\TypeRegimes::all();
        return view("supplier.init", compact('type_person', "type_regimen"));
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["supplier_id"]);

            $result = Suppliers::create($input);
            if ($result) {
                Session::flash('save', 'Se ha creado correctamente');
                return response()->json(['success' => 'true']);
            } else {
                return response()->json(['success' => 'false']);
            }
        }
    }

    public function getSpecial(Request $req) {
        $in = $req->all();
        return Datatables::eloquent(PricesSpecial::where("client_id", $in["client_id"])->orderBy("id","asc"))->make(true);
    }
    public function getBranch(Request $req) {
        $in = $req->all();
        return Datatables::eloquent(Branch::where("client_id", $in["client_id"])->orderBy("id","asc"))->make(true);
    }

    public function updatePrice(Request $data, $id) {
        $input = $data->all();
        if ($input["id"] != '') {
            PricesSpecial::where("client_id", $id)->update(['priority' => false]);
            PricesSpecial::where("id", $input["id"])->update(['priority' => true]);
        } else {
            PricesSpecial::where("client_id", $id)->update(['priority' => false]);
        }
        
        return response()->json(["success" => true]);
    }

    public function storeSpecial(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);

            $result = PricesSpecial::create($input);
            if ($result) {
                Session::flash('save', 'Se ha creado correctamente');
                return response()->json(['success' => 'true']);
            } else {
                return response()->json(['success' => 'false']);
            }
        }
    }
    
    public function storeBranch(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);

            $result = Branch::create($input);
            if ($result) {
                Session::flash('save', 'Se ha creado correctamente');
                return response()->json(['success' => 'true']);
            } else {
                return response()->json(['success' => 'false']);
            }
        }
    }

    public function edit($id) {
        $resp["header"] = Suppliers::FindOrFail($id);
        $resp["images"] = Administration\SuppliersDocument::where("supplier_id", $id)->get();
        return response()->json($resp);
    }

    public function update(Request $request, $id) {
        $supplier = Suppliers::FindOrFail($id);
        $input = $request->all();
        $result = $supplier->fill($input)->save();
        if ($result) {
            Session::flash('save', 'Se ha creado correctamente');
            return response()->json(['success' => 'true']);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

    public function destroy($id) {
        $supplier = Suppliers::FindOrFail($id);
        $result = $supplier->delete();
        Session::flash('delete', 'Se ha eliminado correctamente');
        if ($result) {
            Session::flash('save', 'Se ha creado correctamente');
            return response()->json(['success' => 'true']);
        } else {
            return response()->json(['success' => 'false']);
        }
    }
    
  

    public function uploadImage(Request $req) {
        $data = $req->all();
        $file = array_get($data, 'kartik-input-700');
        $name = $file[0]->getClientOriginalName();
//        dd($data);exit;
        $file[0]->move("images/supplier/" . $data["id"], $name);

        Administration\SupplierDocument::where("supplier_id", $data["id"])->get();
        $supplier = new Administration\SupplierDocument();
        $supplier->supplier_id = $data["id"];
        $supplier->document_id = $data["document_id"];
        $supplier->path = $data["id"] . "/" . $name;
        $supplier->save();
        return response()->json(["id" => $data["id"]]);
    }

    public function checkmain(Request $data, $id) {
        $input = $data->all();
        $supplier = Suppliers::find($input["id"]);

        \Illuminate\Support\Facades\DB::table("supplierdocument")->where("supplier_id", $input["id"])->update(['main' => false]);
        $image = Administration\SupplierDocument::where("id", $id)->update(['main' => true]);
        $image = Administration\SupplierDocument::find($id);
        $supplier->image = $image->path;
        $supplier->save();
        return response()->json(["response" => true, "path" => $image]);
    }

    public function deleteImage(Request $data, $id) {
        $image = Administration\SupplierDocument::find($id);
        $image->delete();
        Administration\SupplierDocument::where("supplier_id", $data["supplier_id"]);
        return response()->json(["response" => true, "path" => $data->all()]);
    }
    
    public function deleteBranch(Request $data, $id) {
        $image = Branch::find($id);
        $image->delete();
        return response()->json(["success" => true]);
    }

    public function getImages($id) {
        $image = Administration\SupplierDocument::where("supplier_id", $id)->get();
        return response()->json($image);
    }

}
