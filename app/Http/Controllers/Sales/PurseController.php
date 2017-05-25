<?php

namespace App\Http\Controllers\Sales;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PurseController extends Controller {

    public function index() {
        return view("Sales.Purse.init");
    }

}
