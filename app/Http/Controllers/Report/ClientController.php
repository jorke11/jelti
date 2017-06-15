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
            SELECT cli.id,cli.business,sum(d.quantity) totalunidades,sum(d.value*d.quantity*d.units_sf) total,
            replace(round(sum(d.value*d.quantity*d.units_sf))::money::text,',','.') totalformat 
            FROM sales_detail d 
            JOIN sales s ON s.id=d.sale_id 
            JOIN departures dep ON dep.id=s.departure_id 
            JOIN stakeholder cli ON cli.id=s.client_id 
            WHERE product_id is not null 
            AND dep.status_id=2
            AND dep.created BETWEEN '" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59'
            GROUP BY 1,2 
            ORDER BY 3 DESC";
//        echo $sql;exit;
        $res = DB::select($sql);
        return response()->json(["data" => $res]);
    }

}
