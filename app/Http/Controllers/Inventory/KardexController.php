<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KardexController extends Controller {

    public function index() {
        $kardex = \Illuminate\Support\Facades\DB::table("kardex")->get();
        return view("kardex.init", compact("kardex"));
    }

}
