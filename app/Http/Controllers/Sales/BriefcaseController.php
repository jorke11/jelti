<?php

namespace App\Http\Controllers\Sales;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Parameters;
use DB;
use Datatables;

class BriefcaseController extends Controller {

    public function index() {
        $category = \App\Models\Administration\Categories::all();
        $status = Parameters::where("group", "departure")->get();
        return view("Sales.Briefcase.init", compact("category", "status"));
    }

    public function getList($id) {
        $query = DB::table("vbriefcase")
                ->where("client_id", $id)
                ->orderBy("id", "asc");

        return Datatables::queryBuilder($query)->make(true);
    }

}
