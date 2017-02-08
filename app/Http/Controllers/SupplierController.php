<?php

namespace App\Http\Controllers;

use App\Models\Administration;
use Illuminate\Http\Request;
use Session;

class SupplierController extends Controller {

    public function index() {
        $type_person = Administration\TypePersons::all();
        $type_regimen = Administration\TypeRegimens::all();
        return view("supplier.init", compact('type_person', "type_regimen"));
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);
//            $user = Auth::User();
//            $input["users_id"] = 1;

            $result = Administration\Suppliers::create($input);
            if ($result) {
                Session::flash('save', 'Se ha creado correctamente');
                return response()->json(['success' => 'true']);
            } else {
                return response()->json(['success' => 'false']);
            }
        }
    }

    public function edit($id) {
        $suppliers = Administration\Suppliers::FindOrFail($id);
        return response()->json($suppliers);
    }

    public function update(Request $request, $id) {
        $supplier = Administration\Suppliers::FindOrFail($id);
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
        $supplier = Administration\Suppliers::FindOrFail($id);
        $result = $supplier->delete();
        Session::flash('delete', 'Se ha eliminado correctamente');
        if ($result) {
            Session::flash('save', 'Se ha creado correctamente');
            return response()->json(['success' => 'true']);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

}
