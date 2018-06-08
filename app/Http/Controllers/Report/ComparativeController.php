<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Warehouses;
use DB;

class ComparativeController extends Controller {

    public function __construct() {
        $this->middleware("auth");
    }

    public function index() {
        $warehouse = Warehouses::all();
        $report = array(array("id" => 1, "description" => "Clientes"),
            array("id" => 2, "description" => "Productos"),
            array("id" => 3, "description" => "Categoria"),
            array("id" => 4, "description" => "Proveedor"),
            array("id" => 5, "description" => "Comercial"),
            array("id" => 6, "description" => "Cartera"),
            array("id" => 7, "description" => "Sector"),
        );
        return view("Report.Comparative.init", compact("warehouse", "report"));
    }

    public function salesClient(Request $req) {
        $input = $req->all();
        $where = "";



        $where = "";
        $date = "";

        if (isset($input["init"])) {
            $date = " AND vdepartures.dispatched BETWEEN '" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59'";
        }

        if (isset($input["client_id"]) && $input["client_id"] != 0) {
            $cli = '';
            foreach ($input["client_id"] as $value) {
                $cli .= ($cli == '') ? '' : ',';
                $cli .= $value;
            }
            $where = " AND vdepartures.client_id IN(" . $cli . ")";
        }
        if (isset($input["commercial_id"]) && $input["commercial_id"] != 0) {
            $where .= " AND vdepartures.responsible_id=" . $input["commercial_id"];
        }
        if (isset($input["warehouse_id"]) && $input["warehouse_id"] != 0) {
            $where .= " AND vdepartures.warehouse_id=" . $input["warehouse_id"];
        }

        $header = $this->getHeader($date);

        if ($input["type_report"] == 1) {
            $data = $this->reportSalesClient($input, $where, $date);
        } else if ($input["type_report"] == 2) {
            $data = $this->reportSalesProduct($input,$where, $date);
        } else if ($input["type_report"] == 3) {
            $data = $this->reportSalesCategory($input);
        } else if ($input["type_report"] == 4) {
            $data = $this->reportSalesSupplier($input);
        } else if ($input["type_report"] == 5) {
            $data = $this->reportSalesCommercial($input);
        } else if ($input["type_report"] == 6) {
            $data = $this->reportBriefcase($input);
        } else if ($input["type_report"] == 7) {
            $data = $this->reportSalesSector($input);
        }

        return response()->json(["data" => $data, "header" => $header]);
    }

    function getHeader($dates) {
        $sql = "
            select to_char(dispatched,'YYYY-MM') dates,0 total
            from vdepartures 
            JOIN stakeholder ON stakeholder.id=vdepartures.client_id and stakeholder.type_stakeholder=1
            WHERE vdepartures.status_id IN(2,7) AND client_id  NOT IN(258,264) $dates
            group by 1
            order by 1";
        $header = DB::select($sql);
        return $header;
    }

    function reportSalesSector($data) {
        $sql = "
            select parameters.code id,parameters.description,sum(departures_detail.value * departures_detail.real_quantity * departures_detail.units_sf)::money as total,
            sum(departures_detail.quantity * CASE  WHEN departures_detail.packaging=0 THEN 1 WHEN departures_detail.packaging IS NULL THEN 1 ELSE departures_detail.packaging END) as quantity_packaging
            from departures_detail
            JOIN vdepartures ON vdepartures.id=departures_detail.departure_id and vdepartures.status_id IN(2,7) 
                and vdepartures.client_id NOT IN (258,264,24)
            JOIN stakeholder ON stakeholder.id = vdepartures.client_id and stakeholder.type_stakeholder=1
            JOIN products ON products.id = departures_detail.product_id
            JOIN parameters ON parameters.code=stakeholder.sector_id and parameters.group ='sector'
            group by 1,2
            order by 3 desc
            ";

        $pro = DB::select($sql);

        foreach ($pro as $i => $value) {
            $sql = "
            select 
                to_char(dispatched,'YYYY-MM') as dates,to_char(dispatched,'YYYY-Mon') datestxt,
                sum(departures_detail.value * departures_detail.real_quantity * departures_detail.units_sf)::money as total,
                sum(departures_detail.quantity * CASE  WHEN departures_detail.packaging=0 THEN 1 WHEN departures_detail.packaging IS NULL THEN 1 ELSE departures_detail.packaging END) as quantity_packaging
            from departures_detail
            JOIN vdepartures ON vdepartures.id=departures_detail.departure_id and vdepartures.status_id IN(2,7) and vdepartures.client_id NOT IN(258,264,24)
            JOIN stakeholder ON stakeholder.id=vdepartures.client_id and stakeholder.type_stakeholder=1
            JOIN products ON products.id=departures_detail.product_id
            JOIN parameters ON parameters.code=stakeholder.sector_id and parameters.group ='sector'
            WHERE parameters.code=" . $value->id . "
            group by 1,2
            order by 1
                ";



            $det = DB::select($sql);
            $pro[$i]->detail = $det;
        }

        return $pro;
    }

    function reportBriefcase($data) {
        $sql = "
            select client_id as id,client as description,sum(total)::money as total,sum(payed)::money as totalpayed
            from vbriefcase
            group by 1,2
            order by 3 desc
            ";

        $pro = DB::select($sql);

        foreach ($pro as $i => $value) {
            $sql = "
           select to_char(dispatched,'YYYY-MM') as dates,to_char(dispatched,'YYYY-Mon') datestxt,sum(total)::money as total,sum(coalesce(payed,0))::money totalpayed
            from vbriefcase
            where client_id=" . $value->id . "
            group by 1,2
            order by 1
                ";
            $det = DB::select($sql);
            $pro[$i]->detail = $det;
        }

        return $pro;
    }

    function reportSalesCommercial($data) {
        $sql = "
            select responsible_id as id,responsible as description,sum(subtotal)::money as total,sum(quantity_packaging) as quantity_packaging
            from vdepartures
            WHERE status_id IN(2,7) and client_id NOT IN(258,264,24)
            group by 1,2
            order by 3 desc
            ";

        $pro = DB::select($sql);

        foreach ($pro as $i => $value) {
            $sql = "
            select 
                to_char(dispatched,'YYYY-MM') as dates,to_char(dispatched,'YYYY-Mon') datestxt,sum(subtotal)::money as total,
                sum(quantity_packaging) as quantity_packaging
            from vdepartures
            WHERE responsible_id=" . $value->id . "
            AND status_id IN(2,7) and client_id NOT IN(258,264,24)
            group by 1,2
            order by 1
                ";

            $det = DB::select($sql);
            $pro[$i]->detail = $det;
        }

        return $pro;
    }

    function reportSalesSupplier($data) {
        $sql = "
            select sup.id,sup.business as description,
                sum(departures_detail.value * departures_detail.real_quantity * departures_detail.units_sf)::money as total,
                sum(departures_detail.quantity * CASE  WHEN departures_detail.packaging=0 THEN 1 WHEN departures_detail.packaging IS NULL THEN 1 
                ELSE departures_detail.packaging END) as quantity_packaging
            from departures_detail
            JOIN vdepartures ON vdepartures.id=departures_detail.departure_id and vdepartures.status_id IN(2,7) and vdepartures.client_id NOT IN(258,264,24)
            JOIN stakeholder ON stakeholder.id=vdepartures.client_id and stakeholder.type_stakeholder=1
            JOIN products ON products.id=departures_detail.product_id
            JOIN stakeholder sup ON sup.id=products.supplier_id
            group by 1,2
            order by 3 desc
            ";

        $pro = DB::select($sql);

        foreach ($pro as $i => $value) {
            $sql = "
            select to_char(dispatched,'YYYY-MM') as dates,to_char(dispatched,'YYYY-Mon') datestxt,
            sum(departures_detail.value * departures_detail.real_quantity * departures_detail.units_sf)::money as total,
            sum(departures_detail.real_quantity * CASE  
            WHEN departures_detail.packaging=0 THEN 1 WHEN departures_detail.packaging IS NULL THEN 1 ELSE departures_detail.packaging END) as quantity_packaging
            FROM departures_detail
            JOIN vdepartures ON vdepartures.id=departures_detail.departure_id and vdepartures.status_id IN(2,7) and vdepartures.client_id NOT IN(258,264,24)
            JOIN stakeholder ON stakeholder.id=vdepartures.client_id and stakeholder.type_stakeholder=1
            JOIN products ON products.id=departures_detail.product_id
            JOIN stakeholder sup ON sup.id=products.supplier_id
            WHERE products.supplier_id=" . $value->id . "
            GROUP BY 1,2
            ORDER BY 1
                ";

            $det = DB::select($sql);
            $pro[$i]->detail = $det;
        }

        return $pro;
    }

    function reportSalesCategory($data) {
        $sql = "
            select categories.id,categories.description,
            sum(departures_detail.value * departures_detail.real_quantity * departures_detail.units_sf)::money as total,
            sum(departures_detail.real_quantity * CASE  WHEN departures_detail.packaging=0 THEN 1 WHEN departures_detail.packaging IS NULL 
            THEN 1 ELSE departures_detail.packaging END) as quantity_packaging
            from departures_detail
            JOIN vdepartures ON vdepartures.id=departures_detail.departure_id and vdepartures.status_id IN(2,7) and vdepartures.client_id NOT IN(258,264,24)
            JOIN stakeholder ON stakeholder.id=vdepartures.client_id and stakeholder.type_stakeholder=1
            JOIN products ON products.id=departures_detail.product_id
            JOIN categories ON categories.id=products.category_id
            group by 1,2
            order by 3 desc
            ";

        $pro = DB::select($sql);

        foreach ($pro as $i => $value) {
            $sql = "
            select to_char(dispatched,'YYYY-MM') as dates,to_char(dispatched,'YYYY-Mon') datestxt,
            sum(departures_detail.value * departures_detail.real_quantity * departures_detail.units_sf)::money as total,
            sum(departures_detail.real_quantity * CASE  WHEN departures_detail.packaging=0 THEN 1 WHEN departures_detail.packaging IS NULL 
            THEN 1 ELSE departures_detail.packaging END) as quantity_packaging
            from departures_detail
            JOIN vdepartures ON vdepartures.id=departures_detail.departure_id and vdepartures.status_id IN(2,7) and vdepartures.client_id NOT IN(258,264,24)
            JOIN stakeholder ON stakeholder.id=vdepartures.client_id and stakeholder.type_stakeholder=1
            JOIN products ON products.id=departures_detail.product_id
            JOIN categories categories ON categories.id=products.category_id
            WHERE categories.id=" . $value->id . "
            group by 1,2
            order by 1
                ";

            $det = DB::select($sql);
            $pro[$i]->detail = $det;
        }

        return $pro;
    }

    function reportSalesProduct($data,$where,$dates) {
        $sql = "
            select products.id,substring(products.title from 0 for 40)|| '..' as description,
            sum(departures_detail.value * departures_detail.real_quantity * departures_detail.units_sf)::money as total,
            sum(departures_detail.real_quantity * departures_detail.packaging) as quantity_packaging
            from departures_detail departures_detail
            JOIN vdepartures ON vdepartures.id=departures_detail.departure_id and vdepartures.status_id IN(2,7) and vdepartures.client_id NOT IN(258,264,24)
            JOIN stakeholder ON stakeholder.id=vdepartures.client_id and stakeholder.type_stakeholder=1
            JOIN products ON products.id=departures_detail.product_id
            $dates
            $where
            group by 1,products.title
            order by 3 desc
            ";

        $pro = DB::select($sql);

        foreach ($pro as $i => $value) {
            $sql = "
                SELECT to_char(dispatched,'YYYY-MM') as dates,to_char(dispatched,'YYYY-Mon') datestxt,
                sum(departures_detail.value * departures_detail.real_quantity * departures_detail.units_sf)::money as total,
                coalesce(sum(departures_detail.real_quantity * departures_detail.packaging),0) as quantity_packaging
            FROM departures_detail
            JOIN vdepartures ON vdepartures.id=departures_detail.departure_id AND vdepartures.status_id IN(2,7) AND vdepartures.client_id NOT IN(258,264,24)
            JOIN stakeholder ON stakeholder.id=vdepartures.client_id and stakeholder.type_stakeholder=1
            JOIN products ON products.id=departures_detail.product_id
            Where products.id=" . $value->id . " $dates
            group by 1,2
            order by 1";

            $det = DB::select($sql);
            $pro[$i]->detail = $det;
        }

        return $pro;
    }

    function reportSalesClient($data, $where, $date) {

        $sql = "
            SELECT vdepartures.business_name as description,client_id,sum(subtotal)::money total,sum(quantity_packaging) as quantity_packaging
            FROM vdepartures 
            JOIN stakeholder ON stakeholder.id=vdepartures.client_id and stakeholder.type_stakeholder=1
            WHERE vdepartures.status_id IN(2,7) AND client_id  NOT IN(258,264,24) $date
            $where
            group by 1,2
            order by 3 DESC
            ";
        
        $cli = DB::select($sql);

        foreach ($cli as $i => $value) {
            
            
            $sql = "
            SELECT to_char(dispatched,'YYYY-MM') as dates,to_char(dispatched,'YYYY-Mon') datestxt,coalesce(sum(subtotal),0)::money total,
            sum(quantity_packaging) as quantity_packaging
            FROM vdepartures 
            JOIN stakeholder ON stakeholder.id=vdepartures.client_id and stakeholder.type_stakeholder=1
            WHERE vdepartures.status_id IN(2,7) AND client_id  NOT IN(258,264,24)
            AND client_id=" . $value->client_id . " $date
                $where
            group by 1,2
            order by 1 ASC";
//            echo $sql;exit;
            $det = DB::select($sql);
//            var_dump($value);
//            dd($det);
            
            $cli[$i]->detail = $det;

            foreach ($det as $val) {
                $dates = $val->dates;
                $cli[$i]->$dates = array("total" => $val->total, "quantity_packaging" => $val->quantity_packaging);
            }
        }

        return $cli;
    }

}
