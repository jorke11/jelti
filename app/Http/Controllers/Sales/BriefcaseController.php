<?php

namespace App\Http\Controllers\Sales;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Parameters;

class BriefcaseController extends Controller {

    public function index() {
        $category = \App\Models\Administration\Categories::all();
        $status = Parameters::where("group", "departure")->get();
        return view("Sales.Briefcase.init", compact("category", "status"));
    }

}
