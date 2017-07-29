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

        $sql = "
            SELECT responsible as vendedor,sum(subtotalnumeric) as subtotal,sum(total) total,sum(quantity) quantity
            from vdepartures 
            WHERE created BETWEEN '" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59' and status_id=2
            group by responsible
            order by 3 DESC
            ";
        $res = DB::select($sql);
        return response()->json(["data" => $res]);
    }

    public function listCommercialGraph(Request $req) {
        $input = $req->all();

        $sql = "
            select u.name ||' '|| u.last_name as name,sum(d.quantity) totalunidades,round(sum(d.value * d.quantity * d.units_sf))::int y,
            sum(d.quantity) totalunidades,round(sum(d.value * d.quantity * d.units_sf))::money totalFormated
            from sales_detail d
            JOIN sales s ON s.id=d.sale_id
            JOIN departures dep ON dep.id=s.departure_id AND dep.status_id=2
            JOIN users u ON u.id=s.responsible_id
            WHERE s.created BETWEEN '" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59'
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
                    FROM sales_detail 
                    JOIN sales ON sales.id=sales_detail.sale_id
                    JOIN departures dep ON dep.id=sales.departure_id and dep.status_id=2
                    WHERE product_id = " . $value->id . " and sales.responsible_id=" . $val->id . "
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
            JOIN departures dep ON dep.id=d.departure_id
            JOIN products p ON p.id=d.product_id
            JOIN stakeholder st ON st.id=dep.client_id
            WHERE d.product_id is not null AND dep.created BETWEEN '" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59' $client_id
            GROUP BY 1,2,dep.client_id
            ORDER BY 1 ASC, 3 DESC
            ";

//        echo $sql;exit;
        $res = DB::select($sql);

        return response()->json(["data" => $res]);
    }

}
