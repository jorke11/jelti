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
            WHERE d.status_id IN(2,7) and d.client_id NOT IN(258,264,24)
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
            WHERE d.status_id IN(2,7) and d.client_id NOT IN(258,264,24)
            AND d.dispatched BETWEEN '" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59' $ware
            group by 1
            ";
//        echo $sql;exit;
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
            WHERE d.status_id IN(2,7) and d.client_id NOT IN(258,264)
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
            WHERE status_id IN(2,7) AND d.dispatched BETWEEN '" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59' and d.client_id NOT IN(258,264) $ware
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
            WHERE status_id IN(2,7) AND d.dispatched BETWEEN '" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59' and d.client_id NOT IN(258,264)
                $ware
            group by 1
            order by 1";
        $res = DB::select($sql);

        return response()->json(["data" => $res]);
    }

    public function getMinMax(Request $req) {
        $input = $req->all();

        $ware = "";
        if ($input["warehouse_id"] != 0) {
            $ware = " AND d.warehouse_id=" . $input["warehouse_id"];
        }

        if ($input["client_id"] != 0) {
            $ware .= " AND d.client_id=" . $input["client_id"];
        }


        $sql = "
            select p.*,s.business_name as supplier
            from products p
            JOIN stakeholder s ON s.id=p.supplier_id";

        $res = DB::select($sql);



        //Sentencia(s) SQL
        foreach ($res as $i => $value) {
            $date = array();
            $diasql = date('Y-m-d', strtotime($input['init']));
            $total = 0;
            $quantity = 0;
            $day = array();
            while ($diasql <= $input['end']) {
                $sql = "
                    select sum(d.real_quantity * d.packaging) as quantity,sum(d.real_quantity * d.packaging*value) total
                    from departures_detail d
                    JOIN departures s ON s.id=d.departure_id and s.created_at between '" . $diasql . " 00:00' and '" . $diasql . " 23:59' and s.status_id IN (2,7)
                    where product_id=" . $value->id;

                $det = DB::select($sql);
                $date[][$diasql] = ($det[0]->quantity == null) ? 0 : $det[0]->quantity;
                $quantity += ($det[0]->quantity == null) ? 0 : $det[0]->quantity;
                $total += ($det[0]->total == null) ? 0 : $det[0]->total;
                $day[] = date("d-m", strtotime($diasql));
                $diasql = date('Y-m-d', strtotime($diasql . '+1 day'));
            }
            $res[$i]->date = $date;
            $res[$i]->total = $total;
            $res[$i]->totalF = number_format($total, 0, ".", ",");
            $res[$i]->quantity = $quantity;
        }

        return response()->json(["data" => $res, "date" => $day]);
    }

    public function getNivelService(Request $req) {
        $in = $req->all();

        
        
        $ware = "";
        if ($in["warehouse_id"] != 0) {
            $ware = " AND dep.warehouse_id=" . $in["warehouse_id"];
        }

        if ($in["client_id"] != 0) {
            $ware .= " AND dep.client_id=" . $in["client_id"];
        }

        $sql = "
             SELECT dep.warehouse,
            count(distinct dep.id) as invoices,
            sum(d.quantity*d.packaging) orders_units,
            sum(d.real_quantity*d.packaging) dispatched_units,
            sum(d.quantity*d.packaging) - sum(d.real_quantity*d.packaging) as not_shipped_units,
            round(((sum(d.real_quantity * d.packaging)::float / sum(d.quantity* d.packaging)::float)*100)::numeric,2)||'%' as nivel,
            sum(d.quantity*d.value)::money orders_value,sum(d.real_quantity*d.value)::money dispatched_value,
             (sum(d.quantity*d.value)-sum(d.real_quantity*d.value))::money  as not_shipped_value,
            round(((sum(d.real_quantity * d.value)::float / sum(d.quantity* d.value)::float)*100)::numeric,2)||'%' as nivel_value
            FROM departures_detail d
            JOIN vdepartures dep ON dep.id=d.departure_id and dep.status_id IN (2,7) AND dep.client_id NOT IN(258,264,24)
            JOIN stakeholder ON stakeholder.id=dep.client_id and type_stakeholder=1
                WHERE dep.dispatched BETWEEN '" . $in["init"] . " 00:00' AND '" . $in["end"] . "' $ware
            GROUP BY 1
            ";
        
        
        $res = DB::select($sql);
        return response()->json(["data" => $res]);
        
    }
    public function getNoShipped(Request $req) {
        $in = $req->all();

        
        
        $ware = "";
        if ($in["warehouse_id"] != 0) {
            $ware = " AND dep.warehouse_id=" . $in["warehouse_id"];
        }

        if ($in["client_id"] != 0) {
            $ware .= " AND dep.client_id=" . $in["client_id"];
        }

        
        
        $sql = "
             SELECT p.title as product,dep.warehouse,
 		sum(d.quantity*d.packaging) unit_order,
 		sum(d.real_quantity*d.packaging) units_dispatched,
        sum((d.quantity*d.packaging) - (d.real_quantity*d.packaging)) no_shipped_units,
        (sum(d.quantity*d.packaging-d.real_quantity*d.packaging) * d.value) value_dispatched
            FROM departures_detail d
            JOIN vdepartures dep ON dep.id=d.departure_id and dep.status_id IN (2,7) AND dep.client_id NOT IN(258,264,24)
            JOIN stakeholder ON stakeholder.id=dep.client_id and type_stakeholder=1
            JOIN products p ON p.id=d.product_id
            WHERE dep.dispatched BETWEEN '" . $in["init"] . " 00:00' AND '" . $in["end"] . " 23:59' $ware
            and d.real_quantity<>d.quantity
            GROUP BY 1,2,d.value
            order by 1,2
             
            ";
        
//        echo $sql;exit;
        
        
        $res = DB::select($sql);
        return response()->json(["data" => $res]);
        
    }

}
