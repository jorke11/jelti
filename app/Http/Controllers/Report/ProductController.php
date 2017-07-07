<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Datatables;

class ProductController extends Controller {

    public function index() {
        return view("Report.Product.init");
    }

    public function getList(Request $req) {
        $input = $req->all();

        $sql = "
            SELECT p.id,p.title as product,sum(d.quantity * coalesce(p.packaging,1)) totalunidades,round(sum(d.value * d.quantity * d.units_sf)) as total
            FROM sales_detail d
            JOIN sales s ON s.id=d.sale_id
            JOIN products p ON p.id=d.product_id  
            WHERE product_id is not null
            GROUP by 1,2
            ORDER BY 3 DESC
            ";

        $res = DB::select($sql);
        return response()->json(["data" => $res]);
    }

}
