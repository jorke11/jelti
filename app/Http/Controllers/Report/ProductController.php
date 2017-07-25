<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Datatables;
use App\Models\Administration\Warehouses;

class ProductController extends Controller {

    public function index() {
        $warehouse = Warehouses::all();
        return view("Report.Product.init", compact("warehouse"));
    }

    public function getList(Request $req) {
        $input = $req->all();

        $where = '';
        if ($input["city_id"] != '') {
            $where = "AND s.destination_id=" . $input["city_id"];
        }


        if ($input["product_id"] != '') {
            $where .= " AND d.product_id=" . $input["product_id"];
        }

        $ware = "";
        if ($input["warehouse_id"] != 0) {
            $ware = " AND s.warehouse_id=" . $input["warehouse_id"];
        }


        $sql = "
            SELECT p.id,p.title as product,
            sum(d.quantity * CASE  WHEN packaging=0 THEN 1 WHEN packaging IS NULL THEN 1 ELSE packaging END) totalunidades
            ,round(sum(d.value * d.quantity * coalesce(d.units_sf))) as total
            FROM sales_detail d
            JOIN sales s ON s.id=d.sale_id
            JOIN products p ON p.id=d.product_id  
            WHERE product_id is not null
            AND s.created BETWEEN'" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59'
            $where $ware
            GROUP by 1,2
            ORDER BY 3 DESC
            ";
//        echo $sql;exit;
        $res = DB::select($sql);
        return response()->json(["data" => $res]);
    }

    public function productByCity(Request $req) {
        $input = $req->all();

        $ware = "";
        $ware2 = '';
        if ($input["warehouse_id"] != 0) {
            $ware = " AND s.warehouse_id=" . $input["warehouse_id"];
            $ware2 = " AND sales.warehouse_id=" . $input["warehouse_id"];
        }

        $sql = "
            SELECT c.id,c.description city,
            destination_id,(
                            SELECT sum(d.value* d.quantity * d.units_sf) 
                            FROM sales_detail d
                            JOIN sales s ON s.id=d.sale_id
                            JOIN products p ON p.id=d.product_id
                            WHERE s.destination_id=sales.destination_id
                            AND s.created BETWEEN'" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59'
                                $ware
                            group by product_id
                            order by 1 desc
                            LIMIT 1) as price,
                            (
                            SELECT p.title 
                            FROM sales_detail d
                            JOIN sales s ON s.id=d.sale_id
                            JOIN products p ON p.id=d.product_id
                            WHERE s.destination_id=sales.destination_id
                            AND s.created BETWEEN'" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59' $ware
                            group by 1,product_id
                            order by sum(d.value* d.quantity * d.units_sf)  desc
                            LIMIT 1) as product,
                            (
                            SELECT sum(d.quantity) 
                            FROM sales_detail d
                            JOIN sales s ON s.id=d.sale_id
                            JOIN products p ON p.id=d.product_id
                            WHERE s.destination_id=sales.destination_id
                            AND s.created BETWEEN'" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59' $ware
                            group by product_id
                            order by sum(d.value* d.quantity * d.units_sf)  desc
                            LIMIT 1) as quantity
            FROM sales_detail d
            JOIN sales ON sales.id=d.sale_id
            JOIN cities c ON c.id=sales.destination_id
            WHERE sales.created BETWEEN'" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59'
                $ware2
            GROUP BY 1,2,3
            ORDER by 4 DESC
            ";

        $res = DB::select($sql);
        return response()->json(["data" => $res]);
    }

}
