<?php

namespace App\Http\Controllers\Security;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Security\Users;
use App\Models\Security\Permissions;
use App\Models\Security\PermissionsUser;
use App\Models\Security\Roles;
use App\Models\Administration\Suppliers;
use App\Models\Administration\Cities;
use Session;
use DB;

class UserController extends Controller {

    
    public function index() {
        $profile = Roles::all();
        $supplier = Suppliers::all();
        $city = Cities::all();
        return view("user.init", compact("profile", "supplier", "city"));
    }

    public function create() {
        return "create";
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);
            if (!isset($input["status"])) {
                $input["status"] = false;
            }
            
            $input["password"] = bcrypt($input["password"]); 
//            $user = Auth::User();
//            $input["users_id"] = 1;
            $result = User::create($input);
            if ($result) {
                Session::flash('save', 'Se ha creado correctamente');
                return response()->json(['success' => 'true']);
            } else {
                return response()->json(['success' => 'false']);
            }
        }
    }

    public function edit($id) {
        $resp["header"] = Users::where("id",$id)->first();
        return response()->json($resp);
    }

    public function getPermission($id) {
        $resp["permission"] = DB::select("
                                        SELECT p.permission_id = ANY (SELECT permission_user_id FROM permissions_user where users_id=" . $id . " and permission_id=p.permission_id) allowed,p.*
                                        from permissions p 
                                        WHERE parent_id=0 
                                        AND typemenu_id=0 
                                        ORDER BY priority asc");
        $resp["tree"] = array();

        foreach ($resp["permission"] as $key => $val) {
            $query = "
                                        SELECT p.permission_id = ANY (SELECT permission_id FROM permissions_user where users_id=" . $id . " and permission_id=p.permission_id) allowed,p.*
                                        from permissions p 
                                        WHERE parent_id=" . $val->permission_id . "
                                        ORDER BY priority asc";

            $children = DB::select($query);
            array_push($resp["tree"], $val);
            if (count($children) > 0) {
                foreach ($children as $k => $v) {
                    $resp["tree"][$key]->nodes[] = $v;
                }
            }
        }


        $resp["permissionuser"] = PermissionsUser::where("users_id", $id)->get();

        return response()->json($resp);
    }

    public function update(Request $request, $id) {
        $user = User::FindOrFail($id);
        $input = $request->all();
        if (!isset($input["status"])) {
            $input["status"] = false;
        }
        
      
        $result = $user->fill($input)->save();
        if ($result) {
            Session::flash('save', 'Se ha creado correctamente');
            return response()->json(['success' => 'true']);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

    public function savePermission(Request $request, $id) {
        $input = $request->all();
        $per = explode(",", $input["arr"]);
        $del = PermissionUser::whereNotIn("permission_id", $per)->where("users_id", $id)->delete();

        foreach ($per as $val) {
            $us = PermissionUser::where("permission_id", $val)->where("users_id", $id)->get();
            if (count($us) == 0) {
                $per = new PermissionUser();
                $per->users_id = $id;
                $per->permission_id = $val;
                $per->save();
            }
        }

        Session::flash('save', 'Se ha creado correctamente');
        return response()->json(['success' => 'true']);
    }

    public function destroy($id) {
        $user = User::FindOrFail($id);
        $result = $user->delete();
        Session::flash('delete', 'Se ha eliminado correctamente');
        if ($result) {
            Session::flash('save', 'Se ha creado correctamente');
            return response()->json(['success' => 'true']);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

}
