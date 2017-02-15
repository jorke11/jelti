<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SummaryController extends Controller {

    public function index() {
        $kardex = \Illuminate\Support\Facades\DB::table("summary")->get();
        return view("summary.init", compact("kardex"));
    }

}
