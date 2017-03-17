<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FulfillmentController extends Controller {

    public function __construct() {
        $this->middleware("auth");
    }

    public function index() {
        $meses = array(
            '01'=>'enero', 
            '02'=>'febrero', '03'=>'marzo','04'=> 'abril','05'=> 'mayo','06'=> 'junio','07'=> 'julio',
            '08'=>'agosto','09'=> 'septiembre', '10'=>'octubre', '11'=>'noviembre', '12'=>'diciembre');
        return view("Sellers.provision.init", compact("meses"));
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
            $result = Categories::create($input);
            if ($result) {
                Session::flash('save', 'Se ha creado correctamente');
                return response()->json(['success' => 'true']);
            } else {
                return response()->json(['success' => 'false']);
            }
        }
    }

    public function edit($id) {
        $suppliers = Categories::FindOrFail($id);
        return response()->json($suppliers);
    }

    public function update(Request $request, $id) {
        $category = Categories::FindOrFail($id);
        $input = $request->all();
        $result = $category->fill($input)->save();
        if ($result) {
            Session::flash('save', 'Se ha creado correctamente');
            return response()->json(['success' => 'true']);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

    public function destroy($id) {
        $category = Categories::FindOrFail($id);
        $result = $category->delete();
        Session::flash('delete', 'Se ha eliminado correctamente');
        if ($result) {
            Session::flash('save', 'Se ha creado correctamente');
            return response()->json(['success' => 'true']);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

}
