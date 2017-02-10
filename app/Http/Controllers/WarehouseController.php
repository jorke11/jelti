<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\Core;

class WarehouseController extends Controller
{
    public function index(){
        return view("warehouse.init");
    }
    
    public function create(){
        return "create";
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            
            unset($input["id"]);
//            $user = Auth::User();
//            $input["users_id"] = 1;
            $result = Core\Warehouse::create($input);
            if ($result) {
                Session::flash('save', 'Se ha creado correctamente');
                return response()->json(['success' => 'true']);
            } else {
                return response()->json(['success' => 'false']);
            }
        }
    }

    public function edit($id) {
        $suppliers = Core\Warehouse::FindOrFail($id);
        return response()->json($suppliers);
    }

    public function update(Request $request, $id) {
        $warehouse = Core\Warehouse::FindOrFail($id);
        $input = $request->all();
        $result = $warehouse->fill($input)->save();
        if ($result) {
            Session::flash('save', 'Se ha creado correctamente');
            return response()->json(['success' => 'true']);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

    public function destroy($id) {
        $warehouse = Core\Warehouse::FindOrFail($id);
        $result = $warehouse->delete();
        Session::flash('delete', 'Se ha eliminado correctamente');
        if ($result) {
            Session::flash('save', 'Se ha creado correctamente');
            return response()->json(['success' => 'true']);
        } else {
            return response()->json(['success' => 'false']);
        }
    }
}
