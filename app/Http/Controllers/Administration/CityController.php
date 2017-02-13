<?php

namespace App\Http\Controllers\Administration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\City;
use Session;

class CityController extends Controller {

    public function index() {
        return view("city.init");
    }

    public function create() {
        return "create";
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);
//            $user = Auth::User();
//            $input["users_id"] = 1;
            $result = City::create($input);
            if ($result) {
                Session::flash('save', 'Se ha creado correctamente');
                return response()->json(['success' => 'true']);
            } else {
                return response()->json(['success' => 'false']);
            }
        }
    }

    public function edit($id) {
        $city = City::FindOrFail($id);
        return response()->json($city);
    }

    public function update(Request $request, $id) {
        $city = City::FindOrFail($id);
        $input = $request->all();
        $result = $city->fill($input)->save();
        if ($result) {
            Session::flash('save', 'Se ha creado correctamente');
            return response()->json(['success' => 'true']);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

    public function destroy($id) {
        $city = City::FindOrFail($id);
        $result = $city->delete();
        Session::flash('delete', 'Se ha eliminado correctamente');
        if ($result) {
            Session::flash('save', 'Se ha creado correctamente');
            return response()->json(['success' => 'true']);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

}
