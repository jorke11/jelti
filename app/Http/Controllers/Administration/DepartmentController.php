<?php

namespace App\Http\Controllers\Administration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Department;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Uploads\Base;

class DepartmentController extends Controller {

    public function index() {
        return view("Administration.department.init");
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
            $result = Department::create($input);
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
            $this->path = "uploads/department/" . date("Y-m-d") . "/" . $this->name;

            $file->move("uploads/department/" . date("Y-m-d") . "/", $this->name);

            Excel::load($this->path, function($reader) {
                $in["name"] = $this->name;
                $in["path"] = $this->path;
                $in["quantity"] = count($reader->get());

                $base_id = Base::create($in)->id;

                foreach ($reader->get() as $book) {

                    $dep = Department::where("code", $book->codigo)->first();

                    $department["code"] = $book->codigo;
                    $department["description"] = $book->nombre;

                    if (count($dep) > 0) {
                        $dep->save();
                    } else {
                        Department::create($department);
                    }
                }
            })->get();

            return response()->json(["success" => true, "data" => Department::all()]);
        }
    }

    public function edit($id) {
        $city = Department::FindOrFail($id);
        return response()->json($city);
    }

    public function update(Request $request, $id) {
        $city = Department::FindOrFail($id);
        $input = $request->all();
        $result = $city->fill($input)->save();
        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function destroy($id) {
        $city = Department::FindOrFail($id);
        $result = $city->delete();
        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

}
