<?php

namespace App\Http\Controllers\Administration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration;
use App\Models\Core;
use Session;

class SupplierController extends Controller {

    public function index() {
        $type_person = Administration\TypePerson::all();
        $type_regimen = Administration\TypeRegime::all();
        return view("supplier.init", compact('type_person', "type_regimen"));
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);
//            $user = Auth::User();
//            $input["users_id"] = 1;

            $result = Administration\Supplier::create($input);
            if ($result) {
                Session::flash('save', 'Se ha creado correctamente');
                return response()->json(['success' => 'true']);
            } else {
                return response()->json(['success' => 'false']);
            }
        }
    }

    public function edit($id) {
        $resp["header"] = Administration\Supplier::FindOrFail($id);
        $resp["images"] = Administration\SupplierDocument::where("supplier_id", $id)->get();
        return response()->json($resp);
    }

    public function update(Request $request, $id) {
        $supplier = Administration\Supplier::FindOrFail($id);
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
        $supplier = Administration\Supplier::FindOrFail($id);
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
        $file[0]->move("images/supplier/" . $data["supplier_id"], $name);

        Administration\SupplierDocument::where("supplier_id", $data["supplier_id"])->get();
        $supplier = new Administration\SupplierDocument();
        $supplier->supplier_id = $data["supplier_id"];
        $supplier->document_id = $data["document_id"];
        $supplier->path = $data["supplier_id"] . "/" . $name;
        $supplier->save();
        return response()->json(["id" => $data["supplier_id"]]);
    }

    public function checkmain(Request $data, $id) {
        $input = $data->all();
        $supplier = Administration\Supplier::find($input["supplier_id"]);
        \Illuminate\Support\Facades\DB::table("supplierdocument")->where("supplier_id", $input["supplier_id"])->update(['main' => false]);
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

    public function getImages($id) {
        $image = Administration\SupplierDocument::where("supplier_id", $id)->get();
        return response()->json($image);
    }

}
