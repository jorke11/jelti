<?php

namespace App\Http\Controllers\Security;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Security\Permissions;
use Session;
use DB;

class PermissionController extends Controller {

    public function index() {

        $parents = Permissions::where("typemenu_id", "=", 0)->where("parent_id", "=", 0)->orderBy('priority', 'asc')->get();
        return view("Security.permission.init", compact("parents"));
    }

    public function create() {
        return "create";
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["permission_id"]);
//            $user = Auth::User();
//            $input["users_id"] = 1;

            if (!isset($input["parent_id"]) || $input["parent_id"] == '') {
                $input["parent_id"] = 0;
            }
            $result = Permissions::create($input);
            if ($result) {
                return response()->json(['success' => true, 'data' => $this->getPermission()]);
            } else {
                return response()->json(['success' => false]);
            }
        }
    }

    public function edit($id) {
        $data = Permissions::FindOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, $id) {
        $data = Permissions::FindOrFail($id);
        $input = $request->all();
        $result = $data->fill($input)->save();
        if ($result) {
            Session::flash('save', 'Se ha creado correctamente');
            return response()->json(['success' => true, 'data' => $this->getPermission()]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function destroy($id) {
        $data = Permissions::FindOrFail($id);
        $result = $data->delete();
        if ($result) {
            return response()->json(['success' => true, 'data' => $this->getPermission()]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function getPermission() {
        $data = Permissions::where("typemenu_id", "=", 0)
                        ->where("parent_id", "=", 0)
                        ->orderBy('priority', 'asc')->get();
        $resp = array();

        foreach ($data as $key => $val) {
            $children = Permissions::where("parent_id", $val->id)->orderBy('priority', 'asc')->get();

            array_push($resp, $val);

            if (count($children) > 0) {
                $child = array();
                foreach ($children as $k => $v) {
                    $child[] = $v;
                }
                $resp[$key]->nodes = $child;
            }
        }
        return $resp;
    }

    public function getMenu($id) {
        $data = Permissions::FindOrFail($id);
        return response()->json($data);
    }

}
