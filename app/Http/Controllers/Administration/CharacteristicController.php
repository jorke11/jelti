<?php

namespace App\Http\Controllers\Administration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Characteristic;
use App\Models\Administration\Parameters;
use Session;

class CharacteristicController extends Controller {

    public function __construct() {
        $this->middleware("auth");
    }

    public function index() {
        $types = Parameters::where("group", "type_category")->get();
        return view("Administration.characteristic.init", compact("types"));
    }

    public function create() {
        return "create";
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            try {

                $id = $input["id"];
                unset($input["id"]);
                $file = array_get($input, 'img');
                $alternative = array_get($input, 'alter');

                $input["status_id"] = (isset($input["status_id"])) ? 1 : 0;
                if ($id != '') {
                    $row = Characteristic::find($id);
                    $row->fill($input)->save();
                } else {
                    $id = Characteristic::create($input)->id;
                }

                $row = Characteristic::find($id);

                if ($file != null) {
                    if (file_exists($row->img))
                        unlink($row->img);
                    $name = $file->getClientOriginalName();
                    $path = "images/characteristic/" . $id . "/";
                    $name = str_replace(" ", "", $name);
                    $file->move($path, $name);
                    $path .= $name;
                    $row->img = $path;
                }


                if ($alternative != null) {
                    if (file_exists($row->alternative))
                        unlink($row->alternative);

                    $nameal = $alternative->getClientOriginalName();
                    $pathal = "images/characteristic/" . $id . "/alter/";

                    $nameal = str_replace(" ", "", $nameal);
                    $alternative->move($pathal, $nameal);
                    $pathal .= $nameal;
                    $row->alternative = $pathal;
                }


                $row->save();

                return response()->json(['success' => true]);
            } catch (Exception $ex) {

                return response()->json(['success' => true, "msg" => "Wrong"], 500);
            }
        }
    }

    public function edit($id) {
        $suppliers = Characteristic::FindOrFail($id);
        return response()->json($suppliers);
    }

    public function update(Request $request, $id) {
        $category = Characteristic::FindOrFail($id);

        $input = $request->all();

        $result = $category->fill($input)->save();
        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function destroy($id) {
        $category = Characteristic::FindOrFail($id);
        $result = $category->delete();
        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

}
