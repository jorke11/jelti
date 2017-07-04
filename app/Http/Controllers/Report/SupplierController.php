<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Datatables;

class SupplierController extends Controller {

    public function __construct() {
        $this->middleware("auth");
    }

    public function index() {
        return view("Report.Supplier.init");
    }

    public function getList(Request $req) {
        $input = $req->all();
        $ant = date('Y-m', strtotime('-1 month', strtotime(date("Y-m"))));

        $sql = "
            SELECT s.business,sum(d.quantity * d.value * d.units_supplier) estemes,
            (
            select sum(purchases_detail.quantity * purchases_detail.value * purchases_detail.units_supplier)
            FROM purchases_detail  purchases_detail
            JOIN purchases purchases ON purchases.id=purchases_detail.purchase_id
            where purchases_detail.product_id is not null 
            and purchases.created_at between '" . $ant . "-01 00:00' and '" . $ant . "-30 23:59' and purchases.supplier_id = p.supplier_id) mesanterior

            from purchases_detail  d
            JOIN purchases p ON p.id=d.purchase_id
            JOIN stakeholder s ON s.id=p.supplier_id
            where d.product_id is not null and p.created_at > '" . date("Y-m-") . "01 00:00'
            group by 1,p.supplier_id";

        $res = DB::select($sql);


        $cat = array();
        $series = array();
        
        foreach ($res as $value) {
            $cat[] = $value->business;
            $series[] = array("name" => $value->business, "data" => array((int) $value->mesanterior, (int) $value->estemes));
        }
        
        return response()->json(["data" => $res, "category" => $cat, "series" => $series]);
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
                sta.id,sta.business,sum(d.quantity * d.units_sf) totalunidades,
                SUM(d.quantity * d.value * d.units_sf) + SUM(d.quantity * d.value * d.units_sf * d.tax) +(
                select coalesce(sum(shipping_cost),0) 
                    from sales 
                    where created_at >= '" . $input["init"] . " 00:00' AND created_at <= '" . $input["end"] . " 23:59' 
                        and status_id='1' and client_id=s.client_id
                ) as total,
                (SUM(d.quantity * d.value * d.units_sf) + SUM(d.quantity * d.value * d.units_sf * d.tax) + 
                (
                    select coalesce(sum(shipping_cost),0) 
                    from sales 
                    where created_at >= '" . $input["init"] . " 00:00' AND created_at <= '" . $input["end"] . " 23:59' 
                        and status_id='1' and client_id=s.client_id))::money as totalformated
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
//        echo $sql;exit;
        $res = DB::select($sql);
        return response()->json(["data" => $res]);
    }

}
