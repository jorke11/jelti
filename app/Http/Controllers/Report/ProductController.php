<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Datatables;
use App\Models\Administration\Warehouses;

class ProductController extends Controller {

    public function __construct() {
        $this->middleware("auth");
    }

    public function index() {
        $warehouse = Warehouses::all();
        return view("Report.Product.init", compact("warehouse"));
    }

    public function getList(Request $req) {
        $input = $req->all();
        $where = '';

        if ($input["warehouse_id"] != 0) {
            $where .= " AND s.warehouse_id=" . $input["warehouse_id"];
        }

        if ($input["client_id"] != '') {
            $where .= " AND s.client_id=" . $input["client_id"];
        }

        if ($input["city_id"] != '') {
            $where = "AND s.destination_id=" . $input["city_id"];
        }

        if ($input["product_id"] != '') {
            $where .= " AND p.product_id=" . $input["product_id"];
        }

        if ($input["supplier_id"] != '') {
            $where .= " AND p.supplier_id= " . $input["supplier_id"];
        }

        if ($input["commercial_id"] != '') {
            $where .= " AND s.responsible_id=" . $input["commercial_id"];
        }


        $res = $this->getListProduct($input["init"], $input["end"], $where);
        return response()->json(["data" => $res]);
    }

    public function getListProduct($init, $end, $where = '', $limit = 'LIMIT 10') {
        $sql = "
          SELECT p.id,p.title as product, sum(d.real_quantity * CASE WHEN d.packaging=0 THEN 1 WHEN d.packaging IS NULL THEN 1 ELSE d.packaging END) quantity,
         sum(d.value * d.quantity * d.units_sf) as subtotal 
            FROM departures_detail d 
            JOIN departures s ON s.id=d.departure_id and s.status_id IN(2,7)
            JOIN stakeholder ON stakeholder.id=s.client_id and stakeholder.type_stakeholder=1
            JOIN products p ON p.id=d.product_id 
            WHERE s.dispatched BETWEEN'" . $init . " 00:00' AND '" . $end . " 23:59' AND s.client_id NOT IN(258,264) AND p.category_id<>-1
            $where
            GROUP by 1,2
            ORDER BY 4 DESC
            $limit
            ";

        return DB::select($sql);
    }

    public function productByCity(Request $req) {
        $input = $req->all();
        $where = '';
        $where2 = '';
        if ($input["warehouse_id"] != 0) {
            $where .= " AND departures.warehouse_id=" . $input["warehouse_id"];
            $where2 .= " AND dep.warehouse_id=" . $input["warehouse_id"];
        }

        if ($input["client_id"] != '') {
            $where .= " AND departures.client_id=" . $input["client_id"];
            $where2 .= " AND dep.client_id=" . $input["client_id"];
        }

        if ($input["city_id"] != '') {
            $where = "AND departures.destination_id=" . $input["city_id"];
            $where2 = "AND dep.destination_id=" . $input["city_id"];
        }

        if ($input["product_id"] != '') {
            $where .= " AND d.product_id=" . $input["product_id"];
            $where2 .= " AND d.product_id=" . $input["product_id"];
        }

        if ($input["supplier_id"] != '') {
            $where .= " AND p.supplier_id= " . $input["supplier_id"];
            $where2 .= " AND p.supplier_id= " . $input["supplier_id"];
        }

        if ($input["commercial_id"] != '') {
            $where .= " AND departures.responsible_id=" . $input["commercial_id"];
            $where2 .= " AND dep.responsible_id=" . $input["commercial_id"];
        }
        if ($input["commercial_id"] != '') {
            $where .= " AND departures.responsible_id=" . $input["commercial_id"];
            $where2 .= " AND dep.responsible_id=" . $input["commercial_id"];
        }

        $sql = "
            SELECT c.id,c.description city,
            destination_id,(
                            SELECT sum(d.value* d.quantity * d.units_sf) 
                            FROM departures_detail d
                            JOIN departures ON departures.id=d.departure_id and departures.status_id IN(2,7)      
                            JOIN stakeholder ON stakeholder.id=departures.client_id and stakeholder.type_stakeholder=1
                            JOIN products p ON p.id=d.product_id and p.category_id<>-1
                            WHERE departures.destination_id=dep.destination_id and departures.client_id NOT IN(258,264)
                            AND departures.dispatched BETWEEN'" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59'
                                $where
                            group by product_id
                            order by 1 desc
                            LIMIT 1) as price,
                            (
                            SELECT p.title 
                            FROM departures_detail d
                            JOIN departures ON departures.id=d.departure_id and departures.status_id IN(2,7)
                            JOIN products p ON p.id=d.product_id and p.category_id<>-1
                            WHERE departures.destination_id=dep.destination_id AND departures.client_id NOT IN(258,264)
                            AND departures.dispatched BETWEEN'" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59' $where
                            group by 1,product_id
                            order by sum(d.value* d.quantity * d.units_sf)  desc
                            LIMIT 1) as product,
                            (
                            SELECT sum(d.quantity*CASE WHEN d.packaging=0 THEN 1 WHEN d.packaging IS NULL THEN 1 ELSE d.packaging END) 
                            FROM departures_detail d
                            JOIN departures ON departures.id=d.departure_id and departures.status_id IN(2,7)
                            JOIN products p ON p.id=d.product_id and p.category_id<>-1
                            WHERE departures.destination_id=dep.destination_id AND departures.client_id NOT IN(258,264)
                            AND departures.dispatched BETWEEN'" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59' $where
                            group by product_id
                            order by sum(d.value* d.quantity * d.units_sf)  desc
                            LIMIT 1) as quantity
            FROM departures_detail d
            JOIN departures dep ON dep.id=d.departure_id and dep.status_id IN(2,7)
            JOIN cities c ON c.id=dep.destination_id
             JOIN products p ON p.id=d.product_id and p.category_id<>-1
            WHERE dep.dispatched BETWEEN'" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59' and dep.client_id NOT IN(258,264)
                $where2
            GROUP BY 1,2,3
            ORDER by 4 DESC
            ";
//        $sql = "
//            SELET 
//        
//                ";

        $res = DB::select($sql);
        return response()->json(["data" => $res]);
    }

}
