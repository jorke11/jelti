<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class SalesController extends Controller {

    public function index() {
        return view("Report.Sales.init");
    }

    public function getTotalSales($init, $end) {
        $where = '';
        $sql = "
            SELECT round((sum(d.value * d.quantity * d.units_sf)-
            (select sum(value * quantity * units_sf) 
            from vcreditnote_detail_row 
            where created_at >= '" . $init . " 00:00' AND created_at <= '" . $end . " 23:59'))) as total
            FROM sales_detail d
            JOIN sales s ON s.id=d.sale_id
            JOIN departures dep ON dep.id=s.departure_id and dep.status_id=2
            JOIN products p ON p.id=d.product_id 
            WHERE d.product_id is NOT NULL 
            AND s.created >= '" . $init . " 00:00' AND s.created <= '" . $end . " 23:59'
            ";


//        if ($init != '') {
//            $sql .= " AND created >= '" . $init . " 00:00'";
//        }
//        if ($end != '') {
//            $sql .= " AND created <= '" . $end . " 23:59'";
//        }
        $res = DB::select($sql);
        $total = 0;
        if (count($res) > 0) {
            $total = $res[0]->total;
        }

        if ($init != '') {
            $where = " AND s.created >= '" . $init . " 00:00'";
        }
        if ($end != '') {
            $where .= " AND s.created <= '" . $end . " 23:59'";
        }

        $sql = "
            SELECT sum(sales_detail.quantity) quantity,product_id,p.title
            FROM sales_detail
            JOIN products p ON p.id=sales_detail.product_id
            JOIN sales s ON s.id=sales_detail.sale_id
            WHERE product_id is not null $where
            GROUP BY product_id,p.title
            order by 1 desc	
            limit 2";

        $res2 = DB::select($sql);

        $quantity = array("quantity" => 0, "product_id" => 0, "title" => '');
        if (count($res2) > 0) {
            $quantity = $res2[0];
        }

        return response()->json(["total" => "$ " . number_format($total, 0, ",", "."), "quantity" => $quantity]);
    }

    public function getFulfillmentSup($init, $end) {
        $sql = "
            SELECT p.id, p.idpurchase,en.id entry,s.lead_time,p.created date_purchase,en.created date_entry
            FROM purchases p
            JOIN entries en ON en.purchase_id=p.id
            JOIN stakeholder s ON s.id=p.supplier_id";

        if ($init != '') {
            $sql .= " AND p.created >= '" . $init . " 00:00'";
        }
        if ($end != '') {
            $sql .= " AND p.created <= '" . $end . " 23:59'";
        }


        $res = DB::select($sql);

        foreach ($res as $i => $value) {
            $time = strtotime($value->date_entry) - strtotime($value->date_purchase);
            if ($time < 0) {
                $msg = 'No cumple';
            } else {
                $msg = 'Cumple';
            }

            $res[$i]->fulfillment = $msg;
        }
        return response()->json(["detail" => $res]);
    }

    public function getFulfillmentCli($init, $end) {
        $sql = "
            SELECT 
                id as departure,created,updated_at,date_part('day' ,updated_at-created) days,
                date_part('hours' ,updated_at-created) hours
            From departures
            WHERE status_id=2";

        if ($init != '') {
            $sql .= " AND created >= '" . $init . " 00:00'";
        }
        if ($end != '') {
            $sql .= " AND created <= '" . $end . " 23:59'";
        }
        $sql .= ' ORDER BY 1 desc';

        $res = DB::select($sql);


        return response()->json(["detail" => $res]);
    }

}
