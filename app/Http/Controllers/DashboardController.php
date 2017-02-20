<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller {

    public function index() {
        return view("dashboard");
    }

    public function getMenu() {


        $resp = DB::select("
                        SELECT p.id = ANY (SELECT permission_id FROM permissionuser where users_id=" . Auth::user()->id . " and permission_id=p.id) allowed,p.*
                        from permission p 
                        WHERE parent_id=0 
                        AND typemenu_id=0 
                        ORDER BY priority asc");
        $arr = array();

        if (count($resp)) {
            foreach ($resp as $key => $val) {
                if ($val->allowed == true) {
                    $query = "
                    SELECT p.id = ANY (SELECT permission_id FROM permissionuser where users_id=" . Auth::user()->id . " and permission_id=p.id) allowed,p.*
                    from permission p 
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
                }
            }
        }
        return $arr;
    }

}
