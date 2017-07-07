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
            select d.product_id,p.title product,sum(d.quantity *  coalesce(p.packaging,1)) units
            from sales_detail d
            JOIN sales s ON s.id=d.sale_id 
            JOIN products p ON p.id=d.product_id 
            WHERE d.product_id is Not null
            AND s.created_at BETWEEN'" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59'
            group by 1,2
            order by 3 desc limit 10";
        
        $res = DB::select($cli);
        $units = array();
        $cat = array();
        foreach ($res as $value) {
            $units[] = (int)$value->units;
            $cat[] = $value->product;
        }

        return response()->json(["data" => $res, "categories" => $cat, "units" => $units]);
    }

    public function listCities(Request $req) {
        $input = $req->all();
        $cli = "
            select c.description as data,c.description as name,sum(quantity) y
            from sales_detail d
            JOIN sales s ON s.id=d.sale_id 
            JOIN cities c ON c.id=s.destination_id
            WHERE d.product_id is Not null
            AND s.created_at BETWEEN'" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59'
            group by 1,s.destination_id
            order by 2 desc
            ";
//            echo $cli;exit;

        $res = DB::select($cli);

        return response()->json(["data" => $res]);
    }

}
