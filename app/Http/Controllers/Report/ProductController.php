<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Datatables;

class ProductController extends Controller {

    public function index() {
        return view("Report.Product.init");
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



        $sql = "
            SELECT p.id,p.title as product,
            sum(d.quantity * CASE  WHEN packaging=0 THEN 1 WHEN packaging IS NULL THEN 1 ELSE packaging END) totalunidades
            ,round(sum(d.value * d.quantity * coalesce(d.units_sf))) as total
            FROM sales_detail d
            JOIN sales s ON s.id=d.sale_id
            JOIN products p ON p.id=d.product_id  
            WHERE product_id is not null
            AND s.created BETWEEN'" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59'
            $where
            GROUP by 1,2
            ORDER BY 3 DESC
            ";
//        echo $sql;exit;
        $res = DB::select($sql);
        return response()->json(["data" => $res]);
    }

    public function productByCity(Request $req) {
        $input = $req->all();

        $sql = "
            SELECT p.id,p.title as product,sum(d.quantity * coalesce(p.packaging,1)) totalunidades,round(sum(d.value * d.quantity * d.units_sf)) as total
            FROM sales_detail d
            JOIN sales s ON s.id=d.sale_id
            JOIN products p ON p.id=d.product_id  
            WHERE product_id is not null
            GROUP by 1,2
            ORDER BY 3 DESC
            ";

//        echo $sql;
//        exit;
        $res = DB::select($sql);
        return response()->json(["data" => $res]);
    }

}
