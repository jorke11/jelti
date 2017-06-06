<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Datatables;

class SupplierController extends Controller {

    public function index() {
        return view("Report.Supplier.init");
    }

    public function getList(Request $req) {
        $input = $req->all();
        $query = DB::table('vreportsupplier')->whereBetween("created", array($input["init"] . " 00:00", $input["end"] . " 23:59"));
        return Datatables::queryBuilder($query)->make(true);
    }

}
