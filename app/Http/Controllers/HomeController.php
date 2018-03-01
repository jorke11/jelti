<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
//use App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth;
use App\Models\Administration\Comment;
use App\Models\Security\Users;
use App\Models\Security\Roles;
use App\Models\Administration\Warehouses;
use App\Models\Administration\Categories;
use App\Models\Administration\Characteristic;
use DB;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {


//        $sql = "
//            SELECT p.title,sum(d.quantity *  CASE  WHEN d.packaging=0 THEN 1 WHEN d.packaging IS NULL THEN 1 ELSE d.packaging END) cantidadTotal,
//            round(sum(d.value * d.quantity * d.units_sf)) as total
//            FROM departures_detail d
//            JOIN departures dep ON dep.id=d.departure_id  ANd dep.client_id NOT IN (258,264)
//            JOIN products p ON p.id=d.product_id  
//            WHERE product_id IS NOT NULL AND dep.dispatched BETWEEN '" . date("Y-m") . "-01 00:00' and '" . date("Y-m-d") . " 23:59'
//            GROUP BY 1
//            ORDER BY 2 DESC 
//            LIMIT 1";
        $sql = "
            SELECT p.title,sum(d.real_quantity *  CASE  WHEN d.packaging=0 THEN 1 WHEN d.packaging IS NULL THEN 1 ELSE d.packaging END) cantidadTotal,
            round(sum(d.value * d.real_quantity * d.units_sf)) as total
            FROM departures_detail d
            JOIN departures dep ON dep.id=d.departure_id  ANd dep.client_id NOT IN(258,264,24) and dep.status_id IN(2,7)
            JOIN products p ON p.id=d.product_id  
            WHERE product_id IS NOT NULL AND dep.dispatched BETWEEN '" . date("Y-m") . "-01 00:00' and '" . date("Y-m-d") . " 23:59'
            GROUP BY 1
            ORDER BY 2 DESC 
            LIMIT 1";


        $product = DB::select($sql);

        if (count($product) > 0) {
            $product = $product[0];
        }

        $sql = "
            SELECT client,sum(total) total,sum(subtotalnumeric) subtotal,sum(quantity) as unidades
            FROM vdepartures
            WHERE dispatched BETWEEN '" . date("Y-m") . "-01 00:00' and '" . date("Y-m-d") . " 23:59' AND status_id IN (2,7)
                AND client_id NOT IN(258,264,24)
            group by 1
            ORDER BY 2 DESC
            LIMIT 1
            ";

        $client = DB::select($sql);
        if (count($client) > 0) {
            $client = $client[0];
        }

        $sql = "
            SELECT s.business proveedor,round(sum(d.real_quantity * d.units_sf)) cantidadtotal,round(sum(d.value * d.real_quantity * d.units_sf)) total
            FROM departures_detail d
            JOIN departures dep ON dep.id=d.departure_id AND dep.status_id IN(2,7) and  dep.client_id NOT IN(258,264,24)
            JOIN products p ON p.id=d.product_id  
            JOIN stakeholder s ON s.id=p.supplier_id  
            WHERE d.product_id is not null AND dep.dispatched BETWEEN '" . date("Y-m") . "-01 00:00' and '" . date("Y-m-d") . " 23:59'
            GROUP BY 1
            ORDER BY 3 desc LIMIT 1";
//        echo $sql;exit;
        $supplier = DB::select($sql);

        if (count($supplier) > 0) {
            $supplier = $supplier[0];
        }
        $sql = "
            SELECT u.name ||' '|| u.last_name as vendedor,sum(d.quantity * p.packaging) cantidadtotal,round(sum(d.value * d.quantity * d.units_sf)) total
            FROM departures_detail d
            JOIN products p ON p.id=d.product_id
            JOIN departures dep ON dep.id=d.departure_id AND dep.status_id IN(2,7) and  dep.client_id NOT IN(258,264,24)
            JOIN users u ON u.id=dep.responsible_id
            WHERE d.product_id IS NOT NULL 
            AND dep.dispatched BETWEEN '" . date("Y-m") . "-01 00:00' and '" . date("Y-m-d") . " 23:59'
            GROUP BY 1
            ORDER BY 3 desc";
//        echo $sql;exit;desc
        $commercial = DB::select($sql);

        if (count($commercial) > 0) {
            $commercial = $commercial[0];
        }

        $mes = date('m', strtotime('-1 month', strtotime(date("Y-m"))));
        $year = date('Y', strtotime('-1 month', strtotime(date("Y-m"))));

        $numero = cal_days_in_month(CAL_GREGORIAN, $mes, $year); // 31

        $ant = date('Y-m', strtotime('-1 month', strtotime(date("Y-m"))));


        $sql = "
                SELECT count(*) estemes,(
                                        select count(*) 
                                        from stakeholder where created_at between '" . $ant . "-01 00:00' and '" . $ant . "-" . $numero . " 23:59') mesanterior 
                FROM stakeholder where created_at > '" . date("Y-m") . "-01 00:00'";



        $newClient = DB::select($sql);
        if (count($newClient) > 0) {
            $newClient = $newClient[0];
        }

        $sql = "
            select sum(d.quantity * d.value * d.units_supplier) estemes,
            (select sum(d.quantity * d.value * d.units_supplier)
            from purchases_detail  d
            JOIN purchases p ON p.id=d.purchase_id
            where d.product_id is not null and p.created_at between '" . $ant . "-01 00:00' and '" . $ant . "-" . $numero . " 23:59') mesanterior
            from purchases_detail  d
            JOIN purchases p ON p.id=d.purchase_id
            where d.product_id is not null and p.created > '" . date("Y-m") . "-01 00:00'
        ";
        $purchase = DB::select($sql);
        if (count($purchase) > 0) {
            $purchase = $purchase[0];
        }


        $sql = "
            select sum(quantity) unidades,sum(quantity * value) subtotal
            from samples_detail d
            JOIN samples s ON s.id=d.sample_id
            WHERE s.dispatched between '" . $ant . "-01 00:00' and '" . date("Y-m-d") . " 23:59' and s.status_id=2";


        $samples = DB::select($sql);
        if (count($purchase) > 0) {
            $samples = $samples[0];
        }


        $category = Categories::where("status_id", 1)->orderBy("order", "asc")->get();
        $subcategory = Characteristic::where("status_id", 1)->where("type_subcategory_id", 1)->orderBy("order", "asc")->get();

        if (Auth::user()->status_id == 3) {
            $users = Auth::user();
            $roles = Roles::where("id", $users->role_id)->get();
            $warehouses = Warehouses::all();
            if ($users->status_id == 3) {
                return view('activation', compact("users", "roles", "warehouses", "samples"));
            } else {

                return \Redirect::to('/');
            }
        } else {

            if (Auth::user()->role_id == 2) {

//                return view('client', compact("product", "client", "supplier", "commercial", "samples", "category", "subcategory"));
                return redirect('shopping/0');
            } else {
                return view('dashboard', compact("product", "client", "supplier", "commercial", "newClient", "purchase", "samples", "category"));
            }
        }
    }

    public function getSales() {
        $sql = "
            SELECT 
                to_char(dispatched,'YYYY-Month') as fecha,to_char(dispatched,'YYYY-MM') as fecha_order,
                sum(subtotalnumeric) subtotal ,sum(total) total,sum(quantity_packaging) as quantity
            FROM vdepartures 
            JOIN stakeholder ON stakeholder.id=vdepartures.client_id and stakeholder.type_stakeholder=1
            WHERE vdepartures.status_id IN (2,7)  AND client_id NOT IN(258,264,24)
            GROUP BY to_char(vdepartures.dispatched,'YYYY-Month'),to_char(dispatched,'YYYY-MM') 
            ORDER BY 2 ASC
                ";

        $sales = DB::select($sql);

        $cat = array();
        $total = array();
        $subtotal = array();
        $quantity = array();
        foreach ($sales as $value) {
            $cat[] = trim($value->fecha);
            $total[] = (int) $value->total;
            $subtotal[] = round($value->subtotal);
            $quantity[] = (int) $value->quantity;
        }
        return response()->json(["category" => $cat, "data" => $total, "quantity" => $quantity, "subtotal" => $subtotal]);
    }

    public function getListProduct(Request $req) {
        $input = $req->all();


        $where = "";
        if ($input["warehouse_id"] != 0) {
            $where .= " AND dep.warehouse_id=" . $input["warehouse_id"];
        }

        if ($input["client_id"] != '') {
            $where .= " AND dep.client_id=" . $input["client_id"];
        }

        if ($input["city_id"] != '') {
            $where = "AND dep.destination_id=" . $input["city_id"];
        }

        if ($input["product_id"] != '') {
            $where .= " AND d.product_id=" . $input["product_id"];
        }

        if ($input["supplier_id"] != '') {
            $where .= " AND p.supplier_id= " . $input["supplier_id"];
        }

        if ($input["commercial_id"] != '') {
            $where .= " AND dep.responsible_id=" . $input["commercial_id"];
        }


        $sql = "
            select d.product_id,p.title product,sum(d.quantity *  CASE  WHEN d.packaging=0 THEN 1 WHEN d.packaging IS NULL THEN 1 ELSE d.packaging END) as quantity,sum(d.quantity * d.value*coalesce(d.units_sf,1)) as total
            from departures_detail d
            JOIN departures dep ON dep.id=d.departure_id and dep.status_id IN (2,7)
            JOIN products p ON p.id=d.product_id 
            JOIN stakeholder ON stakeholder.id=dep.client_id and stakeholder.type_stakeholder=1
            WHERE d.product_id is NOT null AND dep.client_id NOT IN(258,264,24)
            AND dep.dispatched BETWEEN'" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59' $where
            group by 1,2
            order by 4 
            desc limit 10";
        $res = DB::select($sql);

        $cat = array();
        $total = array();
        $quantity = array();
        foreach ($res as $value) {
            $cat[] = $value->product;
            $total[] = (int) $value->total;
            $quantity[] = (int) $value->quantity;
        }

        return response()->json(["category" => $cat, "data" => $total, "quantity" => $quantity, "date" => date("F")]);
    }

    public function getListProductDash(Request $req) {
        $input = $req->all();
        $sql = "
            select 
                d.product_id,p.title product,sum(d.real_quantity *  CASE  WHEN d.packaging=0 THEN 1 WHEN d.packaging IS NULL THEN 1 ELSE d.packaging END) as quantity,
                sum(d.real_quantity * d.value * coalesce(d.units_sf,1)) as total
            from departures_detail d
            JOIN departures dep ON dep.id=d.departure_id and dep.status_id=2 and dep.client_id NOT IN(258,264)
            JOIN stakeholder ON stakeholder.id=dep.client_id and stakeholder.type_stakeholder = 1
            JOIN products p ON p.id=d.product_id 
            WHERE d.product_id is NOT null and p.category_id<>-1
            AND dep.dispatched BETWEEN'" . date("Y-m-") . "01 00:00' AND '" . date("Y-m-d") . " 23:59'
            group by 1,2
            order by 4 
            desc limit 10";

        $res = DB::select($sql);

        $cat = array();
        $total = array();
        $quantity = array();
        foreach ($res as $value) {
            $cat[] = $value->product;
            $total[] = (int) $value->total;
            $quantity[] = (int) $value->quantity;
        }


        return response()->json(["category" => $cat, "data" => $total, "quantity" => $quantity, "date" => date("F")]);
    }

    public function getListProductUnits(Request $req) {
        $input = $req->all();
        $cli = "
            select 
            d.product_id,p.title product,sum(d.real_quantity *  CASE  WHEN d.packaging=0 THEN 1 WHEN d.packaging IS NULL THEN 1 ELSE d.packaging END) as quantity,
            sum(d.real_quantity * d.value*coalesce(d.units_sf,1)) as total
            from departures_detail d
            JOIN departures dep ON dep.id=d.departure_id AND dep.status_id IN (2,7) and dep.client_id NOT IN(258,264)
            JOIN products p ON p.id=d.product_id 
            WHERE d.product_id is NOT null
            AND dep.dispatched BETWEEN'" . date("Y-m") . "-01 00:00' AND '" . date("Y-m-d") . " 23:59'
            group by 1,2
            order by 3 
            desc limit 10";

        $res = DB::select($cli);
//        echo $cli;exit;
        $cat = array();
        $total = array();
        $quantity = array();
        foreach ($res as $value) {
            $cat[] = $value->product;
            $total[] = (int) $value->total;
            $quantity[] = (int) $value->quantity;
        }

        return response()->json(["category" => $cat, "data" => $total, "quantity" => $quantity, "date" => date("F")]);
    }

    public function getListSupplier(Request $req) {
        $input = $req->all();
        $init = date("Y-m") . "-01";
        $res = $this->getCEOSupplier($init, date("Y-m-d"));

        $cat = array();
        $total = array();
        $quantity = array();
        foreach ($res as $value) {
            $cat[] = $value->supplier;
            $total[] = (int) $value->subtotal;
            $quantity[] = (int) $value->quantity;
        }

        return response()->json(["category" => $cat, "data" => $total, "quantity" => $quantity, "date" => date("F")]);
    }

    public function getCEOSupplier($init, $end, $warehouse = '') {
        $sql = "
            select st.id,st.business as supplier,sum(d.real_quantity *  CASE  WHEN d.packaging=0 THEN 1 WHEN d.packaging IS NULL THEN 1 ELSE d.packaging END) as quantity,
            sum(d.real_quantity * d.value* d.units_sf) as subtotal
            from departures_detail d
            JOIN departures dep ON dep.id=d.departure_id and dep.status_id IN(2,7) and dep.client_id NOT IN(258,264,24)
            JOIN products p ON p.id=d.product_id 
            JOIN stakeholder st ON st.id=p.supplier_id
            WHERE d.product_id is NOT null and p.category_id<>-1
            AND dep.dispatched BETWEEN '" . $init . " 00:00' AND '" . $end . " 23:59' $warehouse
            group by 1,2
            order by 4 desc
            ";

        return DB::select($sql);
    }

}
