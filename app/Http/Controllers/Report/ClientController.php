<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Invoicing\SaleDetail;
use Datatables;
use DB;
use App\Models\Administration\Warehouses;
use App\Http\Controllers\Report\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Report\CommercialController;
use Auth;
use Session;
use App\Models\Administration\Categories;

class ClientController extends Controller {

    public $total;
    public $subtotal;
    public $quantity;

    public function __construct() {
        $this->middleware("auth");
        $this->total = 0;
        $this->subtotal = 0;
        $this->quantity = 0;
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

        if ($input["client_id"] != 0) {
            $ware .= " AND client_id=" . $input["client_id"];
        }

        if ($input["city_id"] != 0) {
            $ware .= " AND destination_id=" . $input["city_id"];
        }

        if ($input["commercial_id"] != 0) {
            $ware .= " AND vdepartures.responsible_id=" . $input["commercial_id"];
        }

        $res = $this->getListClient($input["init"], $input["end"], $ware);

        return response()->json(["data" => $res]);
    }

    public function getListClient($init, $end, $where = '', $limit = '') {

        $sql = "
            SELECT 
                stakeholder.id,stakeholder.business as client,sum(total) total,sum(subtotalnumeric) subtotal,sum(tax19) tax19,sum(tax5) tax5,
                sum(vdepartures.shipping_cost) shipping
            FROM vdepartures
            JOIN stakeholder ON stakeholder.id=vdepartures.client_id and type_stakeholder=1
            WHERE dispatched BETWEEN '" . $init . " 00:00' AND '" . $end . " 23:59' AND vdepartures.status_id IN(2,7)  $where
                AND vdepartures.client_id NOT IN(258,264)
            group by 1,vdepartures.client_id
            ORDER BY 4 DESC
            $limit
            ";
        
//        echo $sql;exit;
        $res = DB::select($sql);

        foreach ($res as $i => $value) {
            $sql = "
                SELECT sum(d.quantity * CASE  WHEN d.packaging=0 THEN 1 WHEN d.packaging IS NULL THEN 1 ELSE d.packaging END) units
                FROM departures_detail d
                JOIN departures dep ON dep.id=d.departure_id and dep.status_id IN(2,7)
                JOIN products p ON p.id=d.product_id and p.category_id<>-1
                JOIN stakeholder ON stakeholder.id=dep.client_id and stakeholder.type_stakeholder = 1 
                WHERE dep.client_id=" . $value->id . " and dep.dispatched BETWEEN '" . $init . " 00:00' AND '" . $end . " 23:59'
                    AND dep.client_id NOT IN(258,264)";
            $res2 = DB::select($sql);
            $res[$i]->unidades = $res2[0]->units;
        }

        return $res;
    }

    public function getListTarger(Request $req) {
        $input = $req->all();

        $cli = "
            SELECT business, (select count(*) +1 from branch_office where stakeholder_id=stakeholder.id) seats,created_at as created
            FROM stakeholder
            WHERE type_stakeholder=1 
            AND dispatcjed BETWEEN'" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59'";

        $res = DB::select($cli);

        return response()->json(["data" => $res]);
    }

    public function getListProduct(Request $req) {
        $input = $req->all();
        $ware = "";
        if ($input["warehouse_id"] != 0) {
            $ware = " AND s.warehouse_id=" . $input["warehouse_id"];
        }
        if ($input["client_id"] != 0) {
            $ware .= " AND dep.client_id=" . $input["client_id"];
        }

        if ($input["city_id"] != 0) {
            $ware .= " AND dep.destination_id=" . $input["city_id"];
        }
        if ($input["product_id"] != 0) {
            $ware .= " AND d.product_id=" . $input["product_id"];
        }

        $cli = "
            select d.product_id,p.title product,sum(d.quantity *  CASE  WHEN packaging=0 THEN 1 WHEN packaging IS NULL THEN 1 ELSE packaging END) as quantity,sum(d.quantity * d.value*coalesce(d.units_sf,1)) as total
            from departures_detail d
            JOIN departures dep ON dep.id=d.departure_id 
            JOIN products p ON p.id=d.product_id 
            WHERE d.product_id is Not null
            AND dep.dispatched BETWEEN'" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59' $ware and dep.status_id IN(2,7) 
                AND dep.client_id NOT IN(258,264)
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
        $where = "";
        if ($input["warehouse_id"] != 0) {
            $where .= " AND vdepartures.warehouse_id=" . $input["warehouse_id"];
        }

        if ($input["client_id"] != '') {
            $where .= " AND vdepartures.client_id=" . $input["client_id"];
        }

        if ($input["city_id"] != '') {
            $where = "AND vdepartures.destination_id=" . $input["city_id"];
        }

//        if ($input["product_id"] != '') {
//            $where .= " AND d.product_id=" . $input["product_id"];
//        }
//        if ($input["supplier_id"] != '') {
//            $where .= " AND p.supplier_id= " . $input["supplier_id"];
//        }

        if ($input["commercial_id"] != '') {
            $where .= " AND vdepartures.responsible_id=" . $input["commercial_id"];
        }


        $cli = "
            SELECT destination_id,destination,sum(subtotalnumeric) subtotal,sum(quantity) quantity 
            FROM vdepartures
            JOIN stakeholder ON stakeholder.id=vdepartures.client_id and stakeholder.type_stakeholder=1 
            WHERE dispatched BETWEEN'" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59' and vdepartures.status_id IN(2,7)
                AND vdepartures.client_id NOT IN(258,264)
                $where 
            GROUP BY destination_id,2
            ";

        $res = DB::select($cli);


//echo $cli;exit;
        $cat = array();
        $total = array();
        $quantity = array();
        foreach ($res as $value) {
            $cat[] = trim($value->destination);
            $total[] = (int) $value->subtotal;
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

        if ($input["client_id"] != 0) {
            $ware .= " AND dep.client_id=" . $input["client_id"];
        }

        if ($input["city_id"] != 0) {
            $ware .= " AND dep.destination_id=" . $input["city_id"];
        }

        if ($input["product_id"] != 0) {
            $ware .= " AND d.product_id=" . $input["product_id"];
        }
        if ($input["commercial_id"] != 0) {
            $ware .= " AND dep.responsible_id=" . $input["commercial_id"];
        }
        if ($input["supplier_id"] != 0) {
            $ware .= " AND p.supplier_id=" . $input["supplier_id"];
        }

        $res = $this->getCEOProduct($input["init"], $input["end"], $ware);

        return response()->json(["data" => $res]);
    }

    public function getCEOProduct($init, $end, $where = '', $limit = '') {
        $cli = "
            SELECT c.description category,sum(d.quantity * CASE  WHEN d.packaging=0 THEN 1 WHEN d.packaging IS NULL THEN 1 ELSE d.packaging END) as quantity,
            sum(d.value * d.units_sf * d.quantity) subtotal 
            FROM departures_detail d 
            JOIN vdepartures dep ON dep.id=d.departure_id and dep.status_id IN(2,7)
            JOIN stakeholder ON stakeholder.id=dep.client_id and stakeholder.type_stakeholder=1
            JOIN products p ON p.id=d.product_id
            JOIN categories c ON c.id = p.category_id
            WHERE product_id IS NOT NULL AND dep.dispatched BETWEEN'" . $init . " 00:00' AND '" . $end . " 23:59' AND dep.client_id NOT IN(258,264)
                $where
            GROUP bY 1,p.category_id
            ORDER by 3 DESC
            $limit";

        return DB::select($cli);
    }

    public function profile() {
        $warehouse = Warehouses::all();

        return view("Report.Profile.init", compact("warehouse"));
    }

    public function profileClient(Request $req, $client_id) {
        $input = $req->all();

        $client = DB::table("vclient")->where("id", $input["client_id"])->first();

        $detail = DB::table("vdepartures")->where("client_id", $client->id)->orderBy("id", "asc")->get();
        $resta = 0;

        for ($i = 1; $i < count($detail); $i++) {
            $resta += $this->dias_transcurridos($detail[$i - 1]->created, $detail[$i]->created);
        }

        $sql = "SELECT sum(subtotalnumeric) subtotal,sum(quantity) quantity 
            FROM vdepartures
            JOIN stakeholder ON stakeholder.id=vdepartures.client_id and stakeholder.type_stakeholder=1 
            and vdepartures.client_id NOT IN(258,264)
            WHERE dispatched BETWEEN '" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59' and vdepartures.status_id IN(2,7)
                and client_id=" . $client_id;
        
        $totales = DB::select($sql);
        $totales = $totales[0];
        $totales->subtotalFormated = "$ " . number_format($totales->subtotal, 0, ",", ".");

        $sql = "SELECT count(*) total
            FROM vdepartures
            JOIN stakeholder ON stakeholder.id=vdepartures.client_id and stakeholder.type_stakeholder=1 and vdepartures.client_id NOT IN(258,264)
            WHERE dispatched BETWEEN'" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59' and vdepartures.status_id IN(2,7)
                and client_id=" . $input["client_id"];

        $quantity = DB::select($sql);

        $quantity = ($quantity[0]->total == 0) ? 1 : $quantity[0]->total;

        $ticket = $totales->subtotal / $quantity;
        $ticket = "$ " . number_format($ticket, 0, ",", ".");

        $sql = "
            SELECT c.id,c.description,count(*)
            FROM products p
            JOIN categories c ON c.id=p.category_id
            GROUP by 1
            ORDER BY 2";
        $categories = DB::select($sql);
        foreach ($categories as $i => $value) {
            $sql = "
                select count(*) total
                from departures_detail d  
                JOIN products p ON p.id=d.product_id
                JOIN departures dep ON dep.id=d.departure_id and dep.status_id IN(2,7)
                JOIN stakeholder ON stakeholder.id=dep.client_id and stakeholder.type_stakeholder=1 
                WHERE dep.client_id=" . $input["client_id"] . " and p.category_id = " . $value->id . "
                    AND dispatched BETWEEN'" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59' ";

            $q = DB::select($sql);
            $q = $q[0]->total;
            $categories[$i]->total = $q;
        }

        $sql = "
            select dispatched
            from vdepartures 
            where status_id IN(2,7) and client_id not in(254,264)  and client_id=" . $input["client_id"] . "
            order by dispatched desc limit 1";

        $last_sale = DB::select($sql);
        $last_sale = $last_sale[0]->dispatched;


        return response()->json(["client" => $client, "frecuency" => ceil($resta / count($detail)), "totales" => $totales,
                    "ticket" => $ticket, "total_request" => $quantity, "categories" => $categories, "last_dispatched" => $last_sale]);
    }

    public function getRepurchase(Request $req, $client_id) {
        $in = $req->all();
        $sql = " select id,title from products where category_id<>-1";
        $pro = DB::select($sql);

        $sql = "select 
                    id,invoice,dispatched
                from vdepartures 
                where status_id IN(2,7) AND dispatched between '" . $in["init"] . " 00:00' and '" . $in["end"] . " 23:59' and client_id=" . $client_id;
        $dep = DB::select($sql);

        $arrDep = array();
        foreach ($pro as $i => $value) {
            foreach ($dep as $val) {
                $sql = "SELECT sum(quantity * CASE  WHEN d.packaging=0 THEN 1 WHEN d.packaging IS NULL THEN 1 ELSE d.packaging END) total
                        from departures_detail d
                        JOIN departures dep ON dep.id=d.departure_id and dep.status_id IN(2,7)
                        where departure_id=" . $val->id . " and product_id = " . $value->id . " 
                        AND dispatched between '" . $in["init"] . " 00:00' and '" . $in["end"] . " 23:59'
                        AND dep.client_id=" . $client_id;
                $quantity = DB::select($sql);
                $quantity = $quantity[0];
                $arrDep[$val->invoice] = array("quantity" => ($quantity->total == null) ? '0' : $quantity->total, "date" => date("d-M", strtotime($val->dispatched)));
            }
            $pro[$i]->quantity_dep = $arrDep;
        }

        return response()->json(["products" => $pro]);
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

        $this->getSalesUnitsData($in["init"], $in["end"]);
        $total = $this->total;
        $subtotal = $this->subtotal;
        $quantity = $this->quantity;


        $sql = "
            SELECT s.business
            FROM vdepartures d
            JOIN stakeholder s ON s.id=d.client_id and s.type_stakeholder=1 and d.status_id IN(2,7)
            WHERE dispatched BETWEEN '" . $in["init"] . " 00:00' and '" . $in["end"] . " 23:59' AND d.client_id NOT IN(258,264)
                group by 1";

        $res = DB::select($sql);
        $client = 0;

        if (count($res) > 0) {
            $client = count($res);
        }

        $sql = "
                SELECT count(vdepartures.*) invoices,sum(subtotalnumeric) as subtotal
                FROM vdepartures 
                JOIN stakeholder s ON s.id=vdepartures.client_id and s.type_stakeholder=1
                WHERE vdepartures.status_id IN(2,7)  AND vdepartures.client_id NOT IN(258,264)
                AND dispatched BETWEEN '" . $in["init"] . " 00:00' and '" . $in["end"] . " 23:59'";

        $res = DB::select($sql);
        $invoices = $res[0]->invoices;
        $total = $res[0]->subtotal;

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
        $average = "$ " . number_format(round($total / $div), 0, ",", ".");

        $listClient = $this->getListClient($in["init"], $in["end"], '', 'LIMIT 10');

        $totalcli = 0;
        $quantitycli = 0;
        foreach ($listClient as $i => $value) {
            $totalcli += $value->subtotal;
            $quantitycli += $value->unidades;
            $listClient[$i]->total = number_format($value->total, 0, ".", ",");
        }

        $totalcli = ($totalcli == 0) ? 1 : $totalcli;
        $quantitycli = ($quantitycli == 0) ? 1 : $quantitycli;

        $clipercent = ($totalcli / $subtotal ) * 100;
        $quantitypercent = ($quantitycli / $quantity) * 100;

        $obj = new ProductController();
        $listProduct = $obj->getListProduct($in["init"], $in["end"], '', 'LIMIT 10');

        $totalpro = 0;
        $quantitypro = 0;
        foreach ($listProduct as $i => $value) {
            $totalpro += $value->subtotal;
            $quantitypro += $value->quantity;
            $listProduct[$i]->total = number_format($value->subtotal, 0, ".", ",");
        }


        $totalpro = ($totalpro == 0) ? 1 : $totalpro;
        $quantitypro = ($quantitypro == 0) ? 1 : $quantitypro;
        $pertotalpro = ($totalpro / $subtotal) * 100;
        $perquantitypro = ($quantitypro / $quantity) * 100;

        $listCategory = $this->getCEOProduct($in["init"], $in["end"], '', 'LIMIT 5');

        $totalcat = 0;
        $quantitycat = 0;
        foreach ($listCategory as $i => $value) {
            $totalcat += $value->subtotal;
            $quantitycat += $value->quantity;
            $listCategory[$i]->total = number_format($value->subtotal, 0, ".", ",");
        }
        $totalcat = ($totalcat == 0) ? 1 : $totalcat;
        $quantitycat = ($quantitycat == 0) ? 1 : $quantitycat;

        $pertotalcat = ($totalcat / $subtotal) * 100;
        $perquantitycat = ($quantitycat / $quantity) * 100;

        $home = new HomeController();
        $listSupplier = $home->getCEOSupplier($in["init"], $in["end"], 'LIMIT 5');

        $totalsup = 0;
        $quantitysup = 0;
        foreach ($listSupplier as $i => $value) {
            $totalsup += $value->subtotal;
            $quantitysup += $value->quantity;
            $listSupplier[$i]->total = number_format($value->subtotal, 0, ".", ",");
        }
        $totalsup = ($totalsup == 0) ? 1 : $totalsup;
        $quantitysup = ($quantitysup == 0) ? 1 : $quantitysup;

        $pertotalsup = ($totalsup / $subtotal) * 100;
        $perquantitysup = ($quantitysup / $quantity) * 100;

        $comm = new CommercialController();
        $listCommercial = $comm->getListCommercial($in["init"], $in["end"]);

        $totalcom = 0;
        $quantitycom = 0;


        foreach ($listCommercial as $i => $value) {
            $totalcom += $value->subtotal;
            $quantitycom += $value->quantity;
            $listCommercial[$i]->total = number_format($value->subtotal, 0, ".", ",");
        }
        $totalcom = ($totalcom == 0) ? 1 : $totalcom;
        $quantitycom = ($quantitycom == 0) ? 1 : $quantitycom;

        $pertotalcom = ($totalcom / $subtotal) * 100;
        $perquantitycom = ($quantitycom / $quantity) * 100;


        return response()->json(["client" => $client, "invoices" => $invoices, "total" => $total, 'category' => $category,
                    "supplier" => $supplier, "average" => $average,
                    "listClient" => $listClient, "totalcli" => number_format($totalcli, 0, ",", "."), "quantitycli" => $quantitycli, "pertotal" => $clipercent,
                    "quantitypercent" => $quantitypercent,
                    "listProducts" => $listProduct, "totalpro" => number_format($totalpro, 0, ",", "."), "quantitypro" => $quantitypro, "pertotalpro" => $pertotalpro,
                    "perquantitypro" => $perquantitypro,
                    "listCategory" => $listCategory, "totalcat" => number_format($totalcat, 0, ",", "."), "quantitycat" => $quantitycat,
                    "pertotalcat" => $pertotalcat, "perquantitycat" => $perquantitycat,
                    "listSupplier" => $listSupplier, "totalsupplier" => number_format($totalsup, 0, ",", "."), "quantitysupplier" => $quantitysup,
                    "pertotalsup" => $pertotalsup, "perquantitysup" => $perquantitysup,
                    "listCommercial" => $listCommercial, "totalcom" => number_format($totalcom, 0, ",", "."), "quantitycom" => $quantitycom,
                    "pertotalcom" => $pertotalcom, "perquantitycom" => $perquantitycom]);
    }

    public function getSalesUnits(Request $req) {
        $in = $req->all();
        $res = $this->getSalesUnitsData($in["init"], $in["end"]);

        return response()->json(["data" => $res]);
    }

    public function getSalesUnitsWare(Request $req) {
        $in = $req->all();
        $res = $this->getSalesUnitsDataWare($in["init"], $in["end"]);

        return response()->json(["data" => $res]);
    }

    function getSalesUnitsDataWare($init, $end) {
        $sql = "
                SELECT 
                    warehouse,to_char(dispatched,'YYYY-MM') dates,count(*) invoices,sum(subtotalnumeric) as subtotal,
                    sum(tax19) tax19,sum(total) total, sum(tax5) tax5,sum(vdepartures.shipping_cost) shipping_cost,warehouse_id
                FROM vdepartures 
                JOIN stakeholder ON stakeholder.id=vdepartures.client_id and stakeholder.type_stakeholder=1
                WHERE vdepartures.status_id IN(2,7) AND dispatched BETWEEN '" . $init . " 00:00' and '" . $end . " 23:59'
                    AND client_id  NOT IN(258,264)
                group by 2,warehouse_id,warehouse";
//        echo $sql;
//        exit;
        $res = DB::select($sql);

        $total = 0;
        $subtotal = 0;
        $quantity = 0;
        foreach ($res as $i => $value) {
            list($year, $month) = explode("-", $value->dates);
            $day = date("d", (mktime(0, 0, 0, $month + 1, 1, $year) - 1));

            $sql = "
                SELECT sum(d.quantity * CASE  WHEN d.packaging=0 THEN 1 WHEN d.packaging IS NULL THEN 1 ELSE d.packaging END) quantity
                FROM departures_detail d
                JOIN departures ON departures.id=d.departure_id and departures.status_id IN(2,7) and  departures.client_id NOT IN(258,264)
                JOIN stakeholder ON stakeholder.id=departures.client_id and stakeholder.type_stakeholder=1
                WHERE departures.dispatched between '" . $value->dates . "-01 00:00' AND '" . $value->dates . "-$day 23:59'
                    and departures.warehouse_id=" . $value->warehouse_id . "
                ";
            $res2 = DB::select($sql);
            $res[$i]->quantity = $res2[0]->quantity;
            $res[$i]->dates = date("Y-F", strtotime($value->dates));
            $subtotal += $value->subtotal;
            $total += $value->total;
            $quantity += $res[$i]->quantity;
        }

        $this->subtotal = ($subtotal == 0) ? 1 : $subtotal;
        $this->total = ($total == 0) ? 1 : $total;
        $this->quantity = ($quantity == 0) ? 1 : $quantity;
        return $res;
    }

    function getSalesUnitsData($init, $end) {
        $sql = "
                SELECT 
                    to_char(dispatched,'YYYY-MM') dates,count(*) invoices,sum(subtotalnumeric) as subtotal,sum(tax19) tax19,sum(total) total,
                    sum(tax5) tax5,sum(vdepartures.shipping_cost) shipping_cost
                FROM vdepartures 
                JOIN stakeholder ON stakeholder.id=vdepartures.client_id and stakeholder.type_stakeholder=1
                WHERE vdepartures.status_id IN(2,7) AND dispatched BETWEEN '" . $init . " 00:00' and '" . $end . " 23:59'
                    AND client_id  NOT IN(258,264)
                group by 1";

        $res = DB::select($sql);

        $total = 0;
        $subtotal = 0;
        $quantity = 0;
        foreach ($res as $i => $value) {
            list($year, $month) = explode("-", $value->dates);
            $day = date("d", (mktime(0, 0, 0, $month + 1, 1, $year) - 1));

            $sql = "
                SELECT sum(d.quantity * CASE  WHEN d.packaging=0 THEN 1 WHEN d.packaging IS NULL THEN 1 ELSE d.packaging END) quantity
                FROM departures_detail d
                JOIN departures ON departures.id=d.departure_id and departures.status_id IN(2,7) and  departures.client_id NOT IN(258,264)
                JOIN stakeholder ON stakeholder.id=departures.client_id and stakeholder.type_stakeholder=1
                WHERE departures.dispatched between '" . $value->dates . "-01 00:00' AND '" . $value->dates . "-$day 23:59'
                ";
            $res2 = DB::select($sql);
            $res[$i]->quantity = $res2[0]->quantity;
            $res[$i]->dates = date("Y-F", strtotime($value->dates));
            $subtotal += $value->subtotal;
            $total += $value->total;
            $quantity += $res[$i]->quantity;
        }

        $this->subtotal = ($subtotal == 0) ? 1 : $subtotal;
        $this->total = ($total == 0) ? 1 : $total;
        $this->quantity = ($quantity == 0) ? 1 : $quantity;
        return $res;
    }

}
