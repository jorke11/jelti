<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Warehouses;
use DB;

class OperationsController extends Controller {

    public function __construct() {
        $this->middleware("auth");
    }

    public function index() {
        $warehouse = Warehouses::all();
        return view("Report.Operations.init", compact("warehouse"));
    }

    public function getResponse(Request $req) {
        $input = $req->all();

        $ware = "";
        if ($input["warehouse_id"] != 0) {
            $ware = " AND warehouse_id=" . $input["warehouse_id"];
        }

        $sql = "
            SELECT 
                d.id,d.client,d.invoice,d.created,s.dispatched,date_part('day',s.dispatched-d.created) as dias,
                date_part('hour',s.dispatched-d.created)||':'||CASE WHEN date_part('minutes',s.dispatched-d.created)<=9 THEN date_part('minutes',s.dispatched-d.created) ELSE date_part('minutes',s.dispatched-d.created) END tiempo
            FROM vdepartures d 
            JOIN sales s ON s.departure_id=d.id
            WHERE d.status_id=2
            AND d.dispatched BETWEEN '" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59' $ware
            ";
//echo $sql;exit;
        $res = DB::select($sql);

        return response()->json(["data" => $res]);
    }

    public function ProductWeek(Request $req) {
        $input = $req->all();

        $ware = "";
        if ($input["warehouse_id"] != 0) {
            $ware = " AND warehouse_id=" . $input["warehouse_id"];
        }

        $sql = "
            select to_char(dispatched,'YYYY-MM-DD') fecha,to_char(dispatched,'day') dia,sum(subtotalnumeric) subtotal
            from vdepartures d
            WHERE status_id=2 AND d.dispatched BETWEEN '" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59' $ware
            group by 1,2
            order by 1";
        $res = DB::select($sql);

        return response()->json(["data" => $res]);
    }

    public function ProductDay(Request $req) {
        $input = $req->all();

        $ware = "";
        if ($input["warehouse_id"] != 0) {
            $ware = " AND warehouse_id=" . $input["warehouse_id"];
        }

        $sql = "
            select to_char(dispatched,'day') dia,sum(subtotalnumeric) subtotal
            from vdepartures d
            WHERE status_id=2 AND d.dispatched BETWEEN '" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59' $ware
            group by 1
            order by 1";
        $res = DB::select($sql);

        return response()->json(["data" => $res]);
    }

}
