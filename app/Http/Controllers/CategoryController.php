<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Core;
use Session;

class CategoryController extends Controller {

    public function __construct() {
        $this->middleware("auth");
    }

    public function index() {
        return view("category.init");
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
            $result = Core\Category::create($input);
            if ($result) {
                Session::flash('save', 'Se ha creado correctamente');
                return response()->json(['success' => 'true']);
            } else {
                return response()->json(['success' => 'false']);
            }
        }
    }

    public function edit($id) {
        $suppliers = Core\Category::FindOrFail($id);
        return response()->json($suppliers);
    }

    public function update(Request $request, $id) {
        $categories = Core\Category::FindOrFail($id);
        $input = $request->all();
        $result = $categories->fill($input)->save();
        if ($result) {
            Session::flash('save', 'Se ha creado correctamente');
            return response()->json(['success' => 'true']);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

    public function destroy($id) {
        $category = Core\Category::FindOrFail($id);
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
