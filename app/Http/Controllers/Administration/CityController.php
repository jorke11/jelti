<?php

namespace App\Http\Controllers\Administration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Cities;
use Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Uploads\Base;
use App\Models\Administration\Department;

class CityController extends Controller {

    public function __construct() {
        $this->middleware("auth");
    }
    
    public function index() {
        $div=$e;
        return view("Administration.city.init");
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
            $result = Cities::create($input);
            if ($result) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false]);
            }
        }
    }

    public function storeExcel(Request $request) {
        if ($request->ajax()) {

            $input = $request->all();
            $this->name = '';
            $this->path = '';
            $file = array_get($input, 'file_excel');
            $this->name = $file->getClientOriginalName();
            $this->name = str_replace(" ", "_", $this->name);
            $this->path = "uploads/city/" . date("Y-m-d") . "/" . $this->name;

            $file->move("uploads/city/" . date("Y-m-d") . "/", $this->name);

            Excel::load($this->path, function($reader) {
                $in["name"] = $this->name;
                $in["path"] = $this->path;
                $in["quantity"] = count($reader->get());

                $base_id = Base::create($in)->id;

                foreach ($reader->get() as $book) {
                    $dep = Department::where("code", $book->codigo)->first();

                    $input["department_id"] = $dep->id;
                    $input["code"] = $book->codigo_municipio;
                    $input["description"] = $book->nombre_municipio;

                    $city = Cities::where("code", $book->codigo_municipio)->where("department_id", $dep->id)->first();

                    if (count($city) > 0) {
                        $city->save();
                    } else {
                        Cities::create($input);
                    }
                }
            })->get();

            return response()->json(["success" => true, "data" => Cities::all()]);
        }
    }

    public function edit($id) {
        $city = Cities::FindOrFail($id);
        return response()->json($city);
    }

    public function update(Request $request, $id) {
        $city = Cities::FindOrFail($id);
        $input = $request->all();
        $result = $city->fill($input)->save();
        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function destroy($id) {
        $city = Cities::FindOrFail($id);
        $result = $city->delete();
        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

}
