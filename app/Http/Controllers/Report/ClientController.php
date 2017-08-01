<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Invoicing\SaleDetail;
use Datatables;
use DB;
use App\Models\Administration\Warehouses;

class ClientController extends Controller {

    public function __construct() {
        $this->middleware("auth");
    }

    public function index() {
        $warehouse = Warehouses::all();
        return view("Report.Client.init", compact("warehouse"));
    }

    public function getList(Request $req) {
        $input = $req->all();

        $ware = "";
        if ($input["warehouse_id"] != 0) {
            $ware = " AND warehouse_id=" . $input["warehouse_id"];
        }

        $sql = "
            SELECT stakeholder.business as client,sum(total) total,sum(subtotalnumeric) subtotal,sum(quantity) unidades
            FROM vdepartures
            JOIN stakeholder ON stakeholder.id=vdepartures.client_id 
            WHERE created BETWEEN '" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59' AND vdepartures.status_id=2  $ware
            group by 1,client_id
            ORDER BY 2 DESC
            ";

//        echo $sql;exit;

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
        $ware = "";
        if ($input["warehouse_id"] != 0) {
            $ware = " AND s.warehouse_id=" . $input["warehouse_id"];
        }

        $cli = "
            select d.product_id,p.title product,sum(d.quantity *  CASE  WHEN packaging=0 THEN 1 WHEN packaging IS NULL THEN 1 ELSE packaging END) as quantity,sum(d.quantity * d.value*coalesce(d.units_sf,1)) as total
            from sales_detail d
            JOIN sales s ON s.id=d.sale_id 
            JOIN products p ON p.id=d.product_id 
            WHERE d.product_id is Not null
            AND s.created_at BETWEEN'" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59' $ware
            group by 1,2
            order by 3 desc limit 10";


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
        $ware = "";
        if ($input["warehouse_id"] != 0) {
            $ware = " AND warehouse_id=" . $input["warehouse_id"];
        }

        $cli = "
            SELECT destination_id,destination,sum(total) total,sum(quantity) quantity 
            FROM vdepartures
            WHERE created_at BETWEEN'" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59'
                $ware
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

        $ware = "";
        if ($input["warehouse_id"] != 0) {
            $ware = " AND dep.warehouse_id=" . $input["warehouse_id"];
        }


        $cli = "
            SELECT c.description category,sum(d.quantity * CASE  WHEN packaging=0 THEN 1 WHEN packaging IS NULL THEN 1 ELSE packaging END) as quantity,sum(d.value*d.units_sf*d.quantity) facturado 
FROM sales_detail d 
            JOIN sales ON sales.id=d.sale_id
            JOIN departures dep ON dep.id=sales.departure_id and dep.status_id=2
            JOIN products p ON p.id=d.product_id
            JOIN categories c ON c.id = p.category_id
            WHERE product_id IS NOT NULL AND sales.created_at BETWEEN'" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59'
                $ware
            GROUP bY 1,p.category_id
            ORDER by 2 DESC
            ";
        $res = DB::select($cli);


        return response()->json(["data" => $res]);
    }

    public function profile() {
        $warehouse = Warehouses::all();
        return view("Report.Profile.init", compact("warehouse"));
    }

    public function profileClient($client_id) {
        $client = DB::table("vclient")->where("id", $client_id)->first();

        $detail = DB::table("vdepartures")->where("client_id", $client->id)->orderBy("id", "asc")->get();
        $resta = 0;

        for ($i = 1; $i < count($detail); $i++) {
            $resta += $this->dias_transcurridos($detail[$i - 1]->created, $detail[$i]->created);
        }

        return response()->json(["client" => $client, "frecuency" => ceil($resta / count($detail))]);
    }

    public function dias_transcurridos($fecha_i, $fecha_f) {
        $dias = (strtotime($fecha_i) - strtotime($fecha_f)) / 86400;
        $dias = abs($dias);
        $dias = floor($dias);
        return $dias;
    }

    public function overview() {
        $warehouse = Warehouses::all();
        return view("Report.CEO.init", compact("warehouse"));
    }

    public function getOverview(Request $req) {
        $in = $req->all();

        $sql = "
                SELECT count(*) as quantity 
                FROM stakeholder 
                WHERE type_stakeholder=1";
        $res = DB::select($sql);

        $client = $res[0]->quantity;

        $sql = "
                SELECT count(*) invoices,sum(total) as total
                FROM vdepartures 
                WHERE status_id=2 
                AND created_at BETWEEN '" . $in["init"] . " 00:00' and '" . $in["end"] . " 23:59'";

        $res = DB::select($sql);
        $invoices = $res[0]->invoices;
        $total = $res[0]->total;

        $sql = "
                SELECT count(*) category
                FROM categories";

        $res = DB::select($sql);
        $category = $res[0]->category;

        $sql = "
                SELECT count(*) as quantity 
                FROM stakeholder 
                WHERE type_stakeholder=2";

        $res = DB::select($sql);

        $supplier = $res[0]->quantity;

        $div = ($invoices == 0) ? 1 : $invoices;
        $average = $total / $div;

        $sql = "
            
                SELECT to_char(created,'YYYY-MM'),count(*),sum(total)::money as total 
                FROM vdepartures 
                WHERE status_id=2 AND created_at BETWEEN '" . $in["init"] . " 00:00' and '" . $in["end"] . " 23:59'
                group by 1";
        $res = DB::select($sql);
//        dd($res);
        $valuesDates = $res;


        return response()->json(["client" => $client, "invoices" => $invoices, "total" => $total, 'category' => $category,
                    "supplier" => $supplier, "average" => $average, "valuesdates" => $valuesDates]);
    }

}
