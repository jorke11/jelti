<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Security\Users;

class CommercialController extends Controller {

    public function __construct() {
        $this->middleware("auth");
    }

    public function index() {
        return view("Report.Commercial.init");
    }

    public function listCommercial(Request $req) {
        $input = $req->all();

        $res = $this->getListCommercial($input["init"], $input["end"]);
//        echo "asd";exit;
        return response()->json(["data" => $res]);
    }

    function getListCommercial($init, $end) {
        $sql = "
            SELECT vdepartures.responsible_id,responsible as vendedor,sum(subtotalnumeric) as subtotal,sum(total) total,sum(quantity) quantity
            from vdepartures 
            JOIN stakeholder sta ON sta.id=vdepartures.client_id and sta.type_stakeholder=1
            WHERE dispatched BETWEEN '" . $init . " 00:00' AND '" . $end . " 23:59' and vdepartures.status_id=2 AND client_id <> 258
            group by 1,responsible
            order by 3 DESC
            ";
        
        $res = DB::select($sql);

        foreach ($res as $i => $value) {
            $sql = "
                   SELECT sum(d.quantity * CASE  WHEN d.packaging=0 THEN 1 WHEN d.packaging IS NULL THEN 1 ELSE d.packaging END) quantity
                   FROM departures_detail d
                   JOIN vdepartures dep ON dep.id=d.departure_id and client_id <> 258 and dep.status_id=2
                   JOIN stakeholder s ON s.id=dep.client_id and s.type_stakeholder=1
                   WHERE dispatched BETWEEN '" . $init . " 00:00' AND '" . $end . " 23:59' AND dep.responsible_id=" . $value->responsible_id;
            
            $res2 = DB::select($sql);
            $res[$i]->quantity = $res2[0]->quantity;
        }

        return $res;
    }

    public function listCommercialGraph(Request $req) {
        $input = $req->all();

        $sql = "
            select u.name ||' '|| u.last_name as name,sum(d.quantity) totalunidades,round(sum(d.value * d.quantity * d.units_sf))::int y,
            sum(d.quantity) totalunidades,round(sum(d.value * d.quantity * d.units_sf))::money totalFormated
            from departures_detail d
            JOIN departures dep ON dep.id=d.departure_id AND dep.status_id=2
            JOIN stakeholder sta ON sta.id=dep.client_id and sta.type_stakeholder=1
            JOIN users u ON u.id=dep.responsible_id
            WHERE dep.dispatched BETWEEN '" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59'
            group by 1
            order by 2 desc";
        $res = DB::select($sql);

        return response()->json(["data" => $res]);
    }

    public function getProductByCommercial() {

//        $users = Users::where("role_id", 4)->orWhere("id", [1])->get();
        $users = Users::where("role_id", 4)->orWhere("id", 10)->orWhere("id", 5)->orWhere("id", 6)->get();
        $columns = array();

        $sql = "
            SELECT  products.id,products.title as producto
            FROM products
            ORDER BY 2 asc
            ";

        $res = DB::select($sql);

        $data = array();
        $result = array();

        foreach ($res as $i => $value) {
            $total = 0;
            $users = Users::where("role_id", 4)->orWhere("id", 10)->orWhere("id", 5)->orWhere("id", 6)->get();

            $results[$i]["product"] = $value->producto;
            $data[$i][] = $value->producto;
            foreach ($users as $val) {
                $query = "
                    SELECT coalesce(SUM(quantity),0) as quantity,coalesce(sum(quantity * value * units_sf),0) as facturado
                    FROM departures_detail 
                    JOIN departures dep ON dep.id=departures_detail.departure_id and dep.status_id=2
                    WHERE product_id = " . $value->id . " and dep.responsible_id=" . $val->id . "
                    ";

                $result = DB::select($query);
                $quantity = ($result == null) ? 0 : $result[0]->quantity;
                $results[$i]["quantity_" . strtolower($val->name)] = ($result == null) ? 0 : $result[0]->quantity;
                $results[$i]["facturado_" . strtolower($val->name)] = ($result == null) ? 0 : number_format($result[0]->facturado, 0, ".", ",");
                $data[$i][] = $results[$i]["quantity_" . strtolower($val->name)];
                $data[$i][] = $results[$i]["facturado_" . strtolower($val->name)];

                $total += $result[0]->facturado;
            }
            $data[$i][] = number_format($total, 0, ".", ",");
            $results[$i]["total"] = number_format($total, 0, ".", ",");
        }

//
        foreach ($results[0] as $i => $value) {
            $columns[] = $i;
        }




        return response()->json(["data" => $data, "columns" => $columns]);
    }

    public function getProductByClient(Request $req) {
        $input = $req->all();
        $client_id = '';
        if (isset($input["client_id"]) && $input["client_id"] != '') {
            $client_id = " AND dep.client_id=" . $input["client_id"];
        }
        $columns = array();

        $sql = "
            SELECT 
                st.business client,p.title product,
                sum(d.quantity * CASE  WHEN d.packaging=0 THEN 1 WHEN d.packaging IS NULL THEN 1 ELSE d.packaging END) as quantityproducts,
                sum(d.quantity * d.value * d.units_sf) as total
            FROM departures_detail d
            JOIN departures dep ON dep.id=d.departure_id and dep.status_id=2
            JOIN products p ON p.id=d.product_id
            JOIN stakeholder st ON st.id=dep.client_id and dep.status_id=2 and st.type_stakeholder=1
            WHERE d.product_id is not null AND dep.dispatched BETWEEN '" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59' $client_id
            GROUP BY 1,2,dep.client_id
            ORDER BY 1 ASC, 3 DESC
            ";

//        echo $sql;exit;
        $res = DB::select($sql);

        return response()->json(["data" => $res]);
    }

}
