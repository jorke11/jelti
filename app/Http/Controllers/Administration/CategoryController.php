<?php

namespace App\Http\Controllers\Administration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Categories;
use Session;
use Mail;
use App\Models\Administration\Parameters;

class CategoryController extends Controller {

    public function __construct() {
        $this->middleware("auth");
    }

    public function index() {
        $types = Parameters::where("group", "type_category")->get();
        return view("Administration.category.init", compact("types"));
    }

    public function create() {
        return "create";
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            $id = $input["id"];

            unset($input["id"]);
            $file = array_get($input, 'img');
            
            $input["status_id"] = (isset($input["status_id"])) ? 1 : 0;
            
            if ($id != '') {
                $row = Categories::find($id);
                $row->fill($input)->save();
            } else {
                $id = Categories::create($input)->id;
            }

            if ($file != null) {
                $name = $file->getClientOriginalName();
                $path = "images/category/" . $id . "/";
                $file->move($path, $name);
                $path .= $name;
                $row = Categories::find($id);
                $row->image = $path;
                $row->save();
            }


            if ($id) {
                return response()->json(['success' => true, "data" => $row]);
            } else {
                return response()->json(['success' => false]);
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
        dd($input);
        $result = $category->fill($input)->save();
        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function destroy($id) {
        $category = Categories::FindOrFail($id);
        $result = $category->delete();
        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

}
