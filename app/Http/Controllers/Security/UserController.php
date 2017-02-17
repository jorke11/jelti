<?php

namespace App\Http\Controllers\Security;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Security\User;
use App\Models\Security\Permission;
use App\Models\Security\PermissionUser;
use App\Models\Security\Profile;
use App\Models\Administration\Supplier;
use App\Models\Administration\City;
use Session;

class UserController extends Controller {

    public function index() {
        $profile = Profile::all();
        $supplier = Supplier::all();
        $city = City::all();
        return view("user.init", compact("profile", "supplier", "city"));
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
            $result = Category::create($input);
            if ($result) {
                Session::flash('save', 'Se ha creado correctamente');
                return response()->json(['success' => 'true']);
            } else {
                return response()->json(['success' => 'false']);
            }
        }
    }

    public function edit($id) {
        $resp["header"] = User::FindOrFail($id);
        return response()->json($resp);
    }

    public function getPermission($id) {
        $resp["permission"] = Permission::where("parent_id", 0)->get();
        $resp["tree"] = array();
        foreach ($resp["permission"] as $value) {

            $data = Permission::where("parent_id", $value->id)->get();
            if (count($data) > 0) {
                foreach ($data as $val) {
                    $resp["tree"][] = array("text" => $value->title, "id" => $value->id, "nodes" => array(array("text" => $val->title)));
                }
            } else {
                $resp["tree"][] = array("text" => $value->title, "id" => $value->id);
            }
        }

        $resp["permissionuser"] = PermissionUser::where("users_id", $id)->get();

        return response()->json($resp);
    }

    public function update(Request $request, $id) {
        $user = User::FindOrFail($id);
        $input = $request->all();
        $result = $user->fill($input)->save();
        if ($result) {
            Session::flash('save', 'Se ha creado correctamente');
            return response()->json(['success' => 'true']);
        } else {
            return response()->json(['success' => 'false']);
        }
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
