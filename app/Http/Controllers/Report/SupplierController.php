<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Datatables;

class SupplierController extends Controller {

    public function index() {
        return view("Report.Supplier.init");
    }

    public function getList(Request $req) {
        $input = $req->all();
        $sql = "
            SELECT sta.id,sta.business,
            round(sum(d.quantity::numeric * d.units_sf)) AS totalunidades,
            coalesce(round(sum(d.value * d.quantity::numeric * d.units_sf)),0)::money AS total
            FROM sales_detail d
            JOIN sales s ON s.id=d.sale_id 
            JOIN products p ON p.id = d.product_id
            JOIN stakeholder sta ON sta.id = p.supplier_id
            JOIN departures dep ON dep.id=s.departure_id 
            AND dep.created BETWEEN '" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59'
            WHERE d.product_id IS NOT NULL
            GROUP BY 1
            ORDER BY 3 DESC";

        $res = DB::select($sql);
        return response()->json(["data" => $res]);
    }

    public function getListClient(Request $req) {
        $input = $req->all();
        $pro = '';
        $sup = '';
        
        if ($input["product_id"] != '') {
            $pro = " AND d.product_id = " . $input["product_id"];
        }
        if ($input["supplier_id"] != '') {
            $sup = " AND p.supplier_id = " . $input["supplier_id"];
        }
        $sql = "
            SELECT 
                sta.business,sum(d.quantity * d.units_sf) totalunidades,
                SUM(d.quantity * d.value * d.units_sf) + SUM(d.quantity * d.value * d.units_sf * d.tax) + SUM(dep.shipping_cost) as total,
                (SUM(d.quantity * d.value * d.units_sf) + SUM(d.quantity * d.value * d.units_sf * d.tax) + SUM(dep.shipping_cost))::money as totalformated
            FROM sales_detail d
            JOIN sales s ON s.id=d.sale_id
            JOIN departures dep ON dep.id=s.departure_id
            JOIN products p ON p.id=d.product_id
            JOIN stakeholder sta ON sta.id=s.client_id
            WHERE d.product_id IS NOT NULL
            AND dep.created BETWEEN '" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59'
                $pro $sup
            group by 1,s.client_id
            order by 3 desc";

        $res = DB::select($sql);
        return response()->json(["data" => $res]);
    }

}
