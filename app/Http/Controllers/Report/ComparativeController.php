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
            array("id" => 3, "description" => "Categoria"));
        return view("Report.Comparative.init", compact("warehouse", "report"));
    }

    public function salesClient(Request $req) {
        $input = $req->all();

        $header = $this->getHeader();

        if ($input["type_report"] == 1) {
            $data = $this->reportSalesClient($input);
        } else if ($input["type_report"] == 2) {
            $data = $this->reportSalesProduct($input);
        } else if ($input["type_report"] == 3) {
            $data = $this->reportSalesCategory($input);
        }

        return response()->json(["data" => $data, "header" => $header]);
    }

    function getHeader() {
        $sql = "
            select to_char(dispatched,'YYYY-MM') dates,0 total
            from vdepartures 
            JOIN stakeholder ON stakeholder.id=vdepartures.client_id and stakeholder.type_stakeholder=1
            WHERE vdepartures.status_id IN(2,7) AND client_id  NOT IN(258,264)
            group by 1
            order by 1";
        $header = DB::select($sql);
        return $header;
    }

    function reportSalesCategory($data) {
        $sql = "
            select c.id,c.description as category,sum(det.value * det.real_quantity * det.units_sf)::money as total,sum(det.quantity * CASE  WHEN det.packaging=0 THEN 1 WHEN det.packaging IS NULL THEN 1 ELSE det.packaging END) as quantity_packaging
            from departures_detail det
            JOIN vdepartures d ON d.id=det.departure_id and d.status_id IN(2,7) and d.client_id NOT IN(258,264)
            JOIN stakeholder ON stakeholder.id=d.client_id and stakeholder.type_stakeholder=1
            JOIN products p ON p.id=det.product_id
            JOIN categories c ON c.id=p.category_id
            group by 1,2
            order by 3 desc
            ";

        $pro = DB::select($sql);

        foreach ($pro as $i => $value) {
            $sql = "
            select to_char(dispatched,'YYYY-MM') as dates,to_char(dispatched,'YYYY-Mon') datestxt,sum(det.value * det.real_quantity * det.units_sf)::money as total,sum(det.quantity * CASE  WHEN det.packaging=0 THEN 1 WHEN det.packaging IS NULL THEN 1 ELSE det.packaging END) as quantity_packaging
            from departures_detail det
            JOIN vdepartures d ON d.id=det.departure_id and d.status_id IN(2,7) and d.client_id NOT IN(258,264)
            JOIN stakeholder ON stakeholder.id=d.client_id and stakeholder.type_stakeholder=1
            JOIN products p ON p.id=det.product_id
            JOIN categories c ON c.id=p.category_id
            WHERE c.id=" . $value->id . "
            group by 1,2
            order by 1
                ";
            
            

            $det = DB::select($sql);
            $pro[$i]->detail = $det;
        }

        return $pro;
    }

    function reportSalesProduct($data) {
        $sql = "
            select p.id,substring(p.title from 0 for 40)|| '..' as product,sum(det.value * det.real_quantity * det.units_sf)::money as total,sum(det.quantity * det.packaging) as quantity_packaging
            from departures_detail det
            JOIN vdepartures d ON d.id=det.departure_id and d.status_id IN(2,7) and d.client_id NOT IN(258,264)
            JOIN stakeholder ON stakeholder.id=d.client_id and stakeholder.type_stakeholder=1
            JOIN products p ON p.id=det.product_id
            group by 1,p.title
            order by 3 desc
            ";

        $pro = DB::select($sql);

        foreach ($pro as $i => $value) {
            $sql = "
                SELECT to_char(dispatched,'YYYY-MM') as dates,to_char(dispatched,'YYYY-Mon') datestxt,
                sum(det.value * det.real_quantity * det.units_sf)::money as total,coalesce(sum(det.quantity * det.packaging),0) as quantity_packaging
            FROM departures_detail det
            JOIN vdepartures d ON d.id=det.departure_id AND d.status_id IN(2,7) AND d.client_id NOT IN(258,264)
            JOIN stakeholder ON stakeholder.id=d.client_id and stakeholder.type_stakeholder=1
            JOIN products p ON p.id=det.product_id
            Where p.id=" . $value->id . "
            group by 1,2
            order by 1";

            $det = DB::select($sql);
            $pro[$i]->detail = $det;
        }

        return $pro;
    }

    function reportSalesClient($data) {
        $sql = "
            SELECT client_id,client,sum(subtotalnumeric) total,sum(quantity_packaging) as quantity_packaging
            FROM vdepartures 
            JOIN stakeholder ON stakeholder.id=vdepartures.client_id and stakeholder.type_stakeholder=1
            WHERE vdepartures.status_id IN(2,7) AND client_id  NOT IN(258,264)
            group by 1,client
            order by 3 DESC
            
            ";
        $cli = DB::select($sql);

        foreach ($cli as $i => $value) {
            $sql = "
            SELECT to_char(dispatched,'YYYY-MM') as dates,to_char(dispatched,'YYYY-Mon') datestxt,coalesce(sum(subtotalnumeric),0)::money total,
            sum(quantity_packaging) as quantity_packaging
            FROM vdepartures 
            JOIN stakeholder ON stakeholder.id=vdepartures.client_id and stakeholder.type_stakeholder=1
            WHERE vdepartures.status_id IN(2,7) AND client_id  NOT IN(258,264)
            AND client_id=" . $value->client_id . "
            group by 1,2
            order by 1 ASC";
            $det = DB::select($sql);
            $cli[$i]->detail = $det;
        }

        return $cli;
    }

}
