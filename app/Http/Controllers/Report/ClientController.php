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
        $query = DB::table('vreportclient')->whereBetween("created", array($input["init"] . " 00:00", $input["end"] . " 23:59"));
        return Datatables::queryBuilder($query)->make(true);
    }

}
