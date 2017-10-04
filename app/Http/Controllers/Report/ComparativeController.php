<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Warehouses;
use DB;

class ComparativeController extends Controller {

    public function index() {
        $warehouse = Warehouses::all();

        return view("Report.Comparative.init", compact("warehouse"));
    }

    public function salesClient(Request $req) {
        $input = $req->all();
        $init = date("Y-") . "01-01 00:00";

        $sql = "
            select to_char(dispatched,'YYYY-MM') dates,0 total
            from vdepartures 
            JOIN stakeholder ON stakeholder.id=vdepartures.client_id and stakeholder.type_stakeholder=1
            WHERE vdepartures.status_id IN(2,7) AND client_id  NOT IN(258,264)
            group by 1
            order by 1";
        $header = DB::select($sql);

        $sql = "
            SELECT client_id,client,sum(subtotalnumeric)
            FROM vdepartures 
            JOIN stakeholder ON stakeholder.id=vdepartures.client_id and stakeholder.type_stakeholder=1
            WHERE vdepartures.status_id IN(2,7) AND client_id  NOT IN(258,264)
            group by 1,client
            order by 3 DESC
            LIMIT 10
            ";
        $cli = DB::select($sql);

        $cont = 0;

        $head = $header;

        foreach ($cli as $x => $value) {
            $sql = "
            SELECT to_char(dispatched,'YYYY-MM') as dates,to_char(dispatched,'YYYY-Mon') datestxt,coalesce(sum(subtotalnumeric),0)::money total
            FROM vdepartures 
            JOIN stakeholder ON stakeholder.id=vdepartures.client_id and stakeholder.type_stakeholder=1
            WHERE vdepartures.status_id IN(2,7) AND client_id  NOT IN(258,264)
            AND client_id=" . $value->client_id . "
            group by 1,2
            order by 1 ASC";
            $det = DB::select($sql);
//            $head = $header;
//            foreach ($det as $value) {
//                foreach ($head as $i => $val) {
////                    echo ($value->dates . "==" . $val->dates) . "<br>";
//                    if (isset($val->dates)) {
//                        if ($value->dates == $val->dates) {
//                            $head[$i]->total = $value->total;
////                            echo $value->total . "<br>";
////                            $head[$i]->total = $val->total;
//                        }
//                    }
//                }
//
////                print_r($val);
////                echo "<br><br>";
//            }
//            echo $sql."<br>";
//            if ($x == 2) {
//                dd($det);
//                print_r($cli[$x - 2]);
//                dd($cli[$x - 1]);
//            }

            $cli[$x]->detail = $det;
//            $cli[$x]->detail = $head;
//            $det = [];
//            $head = [];
        }



        return response()->json(["data" => $cli, "header" => $header]);
    }

}
