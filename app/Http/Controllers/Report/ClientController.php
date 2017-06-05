<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Datatables;
use DB;

class ClientController extends Controller {

    public function index() {
        return view("Report.Client.init");
    }

    public function getList(Request $req) {
        $input = $req->all();

        $query = DB::table('vreportclient');
        $sql = "select cli.business,sum(d.quantity) totalunidades,sum(d.value*d.quantity*d.units_sf) total
                from sales_detail d
                JOIN sales s ON s.id=d.sale_id
                JOIN departures dep ON dep.id=s.departure_id
                JOIN stakeholder cli ON cli.id=s.client_id
                where product_id is not null and s.created BETWEEN '" . $input["init"] . " 00:00' AND '" . $input["end"] . " 23:59'
                GROUP BY 1
                ORDER BY 3 DESC";

//        $data = DB::select($sql);
        
        return Datatables::queryBuilder($query)->make(true);
    }

}
