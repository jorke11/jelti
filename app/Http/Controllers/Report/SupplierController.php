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

}
