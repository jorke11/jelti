<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller {

    public $res;

    public function __construct() {
        $this->res = array();
    }

    public function index() {
        return view("dashboard");
    }

    public function getPermission($id) {
        $sql = "
                                        SELECT p.id = ANY (SELECT permission_id FROM permissions_user where users_id=" . $id . " and permission_id=p.id) allowed,p.*
                                        from permissions p 
                                        WHERE parent_id=0 
                                        AND typemenu_id=0 
                                        ORDER BY priority asc";

        $this->resp["permission"] = DB::select($sql);

        $this->recursivePermission($this->resp["permission"], $id);

        $resp["tree"] = $this->resp["tree"];

        $resp["permissionuser"] = PermissionsUser::where("users_id", $id)->get();

        return response()->json($resp);
    }

    public function recursivePermission($param, $id) {
        $cont = 0;
        foreach ($param as $key => $val) {
            $query = "
                                        SELECT p.id = ANY (SELECT permission_id FROM permissions_user where users_id=" . $id . " and permission_id=p.id) allowed,p.*
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

    public function getMenu() {
        echo "asdsa";exit;
        $sql = "
                        SELECT id = ANY (
                                                    SELECT permission_id 
                                                    FROM permissions_user 
                                                    WHERE users_id=" . Auth::user()->id . " 
                                                        AND permission_id=p.id) allowed,p.*
                        from permissions p 
                        WHERE parent_id=0 
                        AND typemenu_id=0 
                        ORDER BY priority asc";

        echo $sql;
        exit;
        $resp = DB::select($sql);


        $arr = array();

        if (count($resp)) {

            foreach ($resp as $key => $val) {
                if ($val->allowed == true) {
                    $query = "
                    SELECT id = ANY (SELECT permission_id FROM permissions_user where users_id=" . Auth::user()->id . " and permission_id=p.id) allowed,p.*
                    from permissions p 
                    WHERE parent_id=" . $val->id . "
                    ORDER BY priority asc";

                    $children = DB::select($query);
                    array_push($arr, $val);
                    if (count($children) > 0) {
                        foreach ($children as $k => $v) {
                            if ($v->allowed == true)
                                $arr[$key]->nodes[] = $v;
                        }
                    }
//                }
                }
            }

            return $arr;
        }
    }

}
