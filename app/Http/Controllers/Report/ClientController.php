<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Invoicing\SaleDetail;
use Datatables;
use DB;

class ClientController extends Controller {

    public function __construct() {
        $this->middleware("auth");
    }

    public function index() {
        return view("Report.Client.init");
    }

    public function getList(Request $req) {
        $input = $req->all();

        $sql = "
            SELECT client,sum(total) total,sum(subtotalnumeric) subtotal,sum(quantity) unidades
            FROM vdepartures
            WHERE created BETWEEN '" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59' AND status_id=2
            group by 1
            ORDER BY 2 DESC
            ";

        $res = DB::select($sql);

        return response()->json(["data" => $res]);
    }

    public function getListTarger(Request $req) {
        $input = $req->all();
        $cli = "
            SELECT business, (select count(*) +1 from branch_office where stakeholder_id=stakeholder.id) seats,created_at as created
            FROM stakeholder
            WHERE type_stakeholder=1 
            AND created_at BETWEEN'" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59'";

        $res = DB::select($cli);

        return response()->json(["data" => $res]);
    }

    public function getListProduct(Request $req) {
        $input = $req->all();
        $cli = "
            select d.product_id,p.title product,sum(d.quantity *  CASE  WHEN packaging=0 THEN 1 WHEN packaging IS NULL THEN 1 ELSE packaging END) as quantity,sum(d.quantity * d.value*coalesce(d.units_sf,1)) as total
            from sales_detail d
            JOIN sales s ON s.id=d.sale_id 
            JOIN products p ON p.id=d.product_id 
            WHERE d.product_id is Not null
            AND s.created_at BETWEEN'" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59'
            group by 1,2
            order by 3 desc limit 10";
//        echo $cli;exit;
        $res = DB::select($cli);

        $cat = array();
        $total = array();
        $quantity = array();
        foreach ($res as $value) {
            $cat[] = $value->product;
            $total[] = (int) $value->total;
            $quantity[] = (int) $value->quantity;
        }

        return response()->json(["category" => $cat, "data" => $total, "quantity" => $quantity]);
    }

    public function listCities(Request $req) {
        $input = $req->all();
        $cli = "
            SELECT destination_id,destination,sum(total) total,sum(quantity) quantity 
            FROM vdepartures
            WHERE created_at BETWEEN'" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59'
            GROUP BY destination_id,2
            ";

        $res = DB::select($cli);
//echo $cli;exit;
        $cat = array();
        $total = array();
        $quantity = array();
        foreach ($res as $value) {
            $cat[] = trim($value->destination);
            $total[] = (int) $value->total;
            $quantity[] = (int) $value->quantity;
        }

        return response()->json(["category" => $cat, "data" => $total, "quantity" => $quantity]);
    }

    public function getProductByCategory(Request $req) {
        $input = $req->all();
        $cli = "
            SELECT c.description category,sum(d.value*d.units_sf*d.quantity) facturado
            FROM sales_detail d
            JOIN sales ON sales.id=d.sale_id
            JOIN departures dep ON dep.id=sales.departure_id and dep.status_id=2
            JOIN products p ON p.id=d.product_id
            JOIN categories c ON c.id = p.category_id
            WHERE product_id IS NOT NULL AND sales.created_at BETWEEN'" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59'
            GROUP bY 1,p.category_id
            ORDER by 2 DESC
            ";

        $res = DB::select($cli);


        return response()->json(["data" => $res]);
    }

}
