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
            $ware = " AND d.warehouse_id=" . $input["warehouse_id"];
        }

        if ($input["client_id"] != 0) {
            $ware .= " AND d.client_id=" . $input["client_id"];
        }

        $sql = "
            SELECT d.client,d.invoice,d.client_id,s.dispatched, d.created,s.dispatched - d.created as dias
            FROM vdepartures d 
            JOIN sales s ON s.departure_id=d.id 
            WHERE d.status_id=2 
            AND d.dispatched BETWEEN '" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59' $ware
            ";
        $res = DB::select($sql);

        return response()->json(["data" => $res]);
    }
    
    public function getShippingCostClient(Request $req) {
        $input = $req->all();

        $ware = "";
        if ($input["warehouse_id"] != 0) {
            $ware = " AND d.warehouse_id=" . $input["warehouse_id"];
        }

        if ($input["client_id"] != 0) {
            $ware .= " AND d.client_id=" . $input["client_id"];
        }

        $sql = "
            SELECT d.client,count(*) pedidos,sum(d.shipping_cost) as valor
            FROM vdepartures d 
            WHERE d.status_id=2 
            AND d.dispatched BETWEEN '" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59' $ware
            group by 1
            ";
        $res = DB::select($sql);

        return response()->json(["data" => $res]);
    }

    public function getAverageTime(Request $req) {
        $input = $req->all();

        $ware = "";
        if ($input["warehouse_id"] != 0) {
            $ware = " AND d.warehouse_id=" . $input["warehouse_id"];
        }

        if ($input["client_id"] != 0) {
            $ware .= " AND d.client_id=" . $input["client_id"];
        }

        $sql = "
            
            SELECT st.business,sum(date_part('day',s.dispatched - d.created))/count(*) promedio
            FROM vdepartures d 
            JOIN sales s ON s.departure_id=d.id 
            JOIN stakeholder st ON st.id=d.client_id
            WHERE d.status_id=2 
            AND d.dispatched BETWEEN '" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59' $ware
            group by 1
            ";
        $res = DB::select($sql);

        return response()->json(["data" => $res]);
    }

    public function ProductWeek(Request $req) {
        $input = $req->all();

        $ware = "";
        if ($input["warehouse_id"] != 0) {
            $ware = " AND d.warehouse_id=" . $input["warehouse_id"];
        }

        if ($input["client_id"] != 0) {
            $ware .= " AND d.client_id=" . $input["client_id"];
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
            $ware = " AND d.warehouse_id=" . $input["warehouse_id"];
        }

        if ($input["client_id"] != 0) {
            $ware .= " AND d.client_id=" . $input["client_id"];
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
