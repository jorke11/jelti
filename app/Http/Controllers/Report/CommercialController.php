<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class CommercialController extends Controller {

    public function index() {
        return view("Report.Commercial.init");
    }

    public function listCommercial(Request $req) {
        $input = $req->all();

        $sql = "
            select u.name ||' '|| u.last_name as vendedor,sum(d.quantity) totalunidades,round(sum(d.value * d.quantity * d.units_sf)) total,
            sum(d.quantity) totalunidades,round(sum(d.value * d.quantity * d.units_sf))::money totalFormated
            from sales_detail d
            JOIN sales s ON s.id=d.sale_id
            JOIN users u ON u.id=s.responsible_id
            WHERE s.created BETWEEN '" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59'
            group by 1
            order by 2 desc";
        $res = DB::select($sql);
        return response()->json(["data" => $res]);
    }
    
    public function listCommercialGraph(Request $req) {
        $input = $req->all();

        $sql = "
            select u.name ||' '|| u.last_name as name,sum(d.quantity) totalunidades,round(sum(d.value * d.quantity * d.units_sf))::int y,
            sum(d.quantity) totalunidades,round(sum(d.value * d.quantity * d.units_sf))::money totalFormated
            from sales_detail d
            JOIN sales s ON s.id=d.sale_id
            JOIN users u ON u.id=s.responsible_id
            WHERE s.created BETWEEN '" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59'
            group by 1
            order by 2 desc";
        $res = DB::select($sql);
        
        return response()->json(["data" => $res]);
    }

}
