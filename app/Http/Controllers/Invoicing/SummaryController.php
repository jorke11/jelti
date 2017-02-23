<?php

namespace App\Http\Controllers\Invoicing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SummaryController extends Controller {

    public function index() {
        $summary = \Illuminate\Support\Facades\DB::table("summary")->get();
        return view("summary.init", compact("summary"));
    }

}
