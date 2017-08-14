<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class SalesController extends Controller {

    public function __construct() {
        $this->middleware("auth");
    }

    public function index() {
        return view("Report.Sales.init");
    }

    public function getTotalSales($init, $end) {
        $where = '';

        $sql = "
            SELECT sum(total) totalsales,sum(quantity) quantity,sum(shipping_cost) as shipping_cost,to_char(created,'YYYY-MM') as month_sales
            FROM vdepartures 
            WHERE dispatched BETWEEN '" . $init . " 00:00' AND '" . $end . " 23:59' and status_id=2
                and client_id<>258
            GROUP BY 4
            ";

        for ($i = 1; $i <= 3; $i++) {
            $newinit = date('Y-m-d', strtotime('-' . $i . ' month', strtotime($init)));
            $newend = date('Y-m-d', strtotime('-' . $i . ' month', strtotime($end)));

            $sql .= "
            UNION
            SELECT sum(total) totalsales,sum(quantity) quantity,sum(shipping_cost) as shipping_cost,to_char(created,'YYYY-MM') as month_sales
            FROM vdepartures 
            WHERE dispatched BETWEEN '" . $newinit . " 00:00' AND <= '" . $newend . " 23:59' and status_id=2
                and client_id<>258
            GROUP BY 4
            ";
        }

        $sql .= " order by 4 DESC";
//        echo $sql;exit;

        $res = DB::select($sql);
//        dd($res);
        $total = 0;
//        echo $sql;exit;
        if (count($res) > 0) {
            $totalsales = $res[0]->totalsales;
            $quantity = $res[0]->quantity;
            $shipping_cost = $res[0]->shipping_cost;
        }

        if ($init != '') {
            $where = " AND s.dispatched >= '" . $init . " 00:00'";
        }
        if ($end != '') {
            $where .= " AND s.dispatched <= '" . $end . " 23:59'";
        }

        $sql = "
            SELECT sum(sales_detail.quantity * CASE  WHEN packaging=0 THEN 1 WHEN packaging IS NULL THEN 1 ELSE packaging END) quantity,product_id,p.title
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

        $cat = array();
        $total = array();
        $quantities = array();
        foreach ($res as $value) {
            $cat[] = $value->month_sales;
            $total[] = (int) $value->totalsales;
            $quantities[] = (int) $value->quantity;
        }

        return response()->json(["totalsales" => "$ " . number_format($totalsales, 0, ",", "."),
                    "quantity" => $quantity,
                    "shipping_cost" => "$ " . number_format($shipping_cost, 0, ",", "."), "category" => $cat, "total" => $total, "quantities" => $quantities]);
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
            WHERE status_id=2 and client_id<>258";

        if ($init != '') {
            $sql .= " AND dispatched >= '" . $init . " 00:00'";
        }
        if ($end != '') {
            $sql .= " AND dispatched <= '" . $end . " 23:59'";
        }
        $sql .= ' ORDER BY 1 desc';

        $res = DB::select($sql);


        return response()->json(["detail" => $res]);
    }

}
