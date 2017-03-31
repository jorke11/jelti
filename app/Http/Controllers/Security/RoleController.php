<?php

namespace App\Http\Controllers\Security;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Security\Roles;
use App\Models\Security\RolesPermission;
use Session;
use DB;

class RoleController extends Controller {

    public $resp;

    public function __construct() {
        $this->resp = array();
    }

    public function index() {
        return view("Security.role.init");
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
            $result = Roles::create($input);
            if ($result) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false]);
            }
        }
    }

    public function edit($id) {
        $profile = Roles::FindOrFail($id);
        return response()->json($profile);
    }

    public function update(Request $request, $id) {
        $profile = Roles::FindOrFail($id);
        $input = $request->all();
        $result = $profile->fill($input)->save();
        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function destroy($id) {
        $profile = Roles::FindOrFail($id);
        $result = $profile->delete();
        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function getPermissionRole($id) {
        $sql = "
                                        SELECT p.id = ANY (SELECT permission_id FROM roles_permission where role_id=" . $id . " and permission_id=p.id) allowed,p.*
                                        from permissions p 
                                        WHERE parent_id=0 
                                        AND typemenu_id=0 
                                        ORDER BY priority asc";
        $main = DB::select($sql);

        $this->recursivePermission($main, $id);
        return response()->json(["success" => true, "tree" => $this->resp["tree"]]);
    }

    public function recursivePermission($param, $id) {
        $cont = 0;
        foreach ($param as $key => $val) {
            $query = "
                                        SELECT p.id = ANY (SELECT permission_id FROM roles_permission where role_id=" . $id . " and permission_id=p.id) allowed,p.*
                                        from permissions p 
                                        WHERE parent_id=" . $val->id . "
                                        ORDER BY priority asc";

            $children = DB::select($query);


            if (count($children) > 0) {
                $this->resp["tree"][$cont] = $val;
                $this->resp["tree"][$cont]->nodes = $children;
                $this->recursivePermission($children, $id);
            } else {
//                $this->resp["tree"][] = $val;
            }
            $cont++;
        }
    }

    public function savePermissionRole(Request $req, $id) {
        $in = $req->all();
        $per = explode(",", $in["arr"]);
        $del = RolesPermission::whereNotIn("permission_id", $per)->where("role_id", $id)->delete();

        foreach ($per as $val) {
            $us = RolesPermission::where("permission_id", $val)->where("role_id", $id)->get();
            if (count($us) == 0) {
                $per = new RolesPermission();
                $per->role_id = $id;
                $per->permission_id = $val;
                $per->save();
            }
        }
        
        return response()->json(['success' => true]);
    }

}
