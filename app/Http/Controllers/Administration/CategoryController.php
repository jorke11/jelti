<?php

namespace App\Http\Controllers\Administration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Categories;
use Session;
use Mail;

class CategoryController extends Controller {

    public function __construct() {
        $this->middleware("auth");
    }

    public function index() {
        return view("Administration.category.init");
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
            $name = $file->getClientOriginalName();


            if ($id != '') {
                $row = Categories::find($id);
                $row->fill($input)->save();
            } else {
                $id = Categories::create($input)->id;
            }

            $path = "images/category/" . $id;

            $file->move($path, $name);
            $path .= "/" . $name;
            $row = Categories::find($id);
            $row->image = $path;
            $row->save();


            if ($id) {
                return response()->json(['success' => true, "header" => $row]);
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
