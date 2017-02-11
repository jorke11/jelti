<?php

namespace App\Http\Controllers\Administration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration;
use App\Models\Core;
use Session;

class SupplierController extends Controller
{
     public function index() {
        $type_person = Administration\TypePersons::all();
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
        $suppliers = Administration\Supplier::FindOrFail($id);
        return response()->json($suppliers);
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
}
