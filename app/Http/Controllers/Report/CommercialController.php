<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommercialController extends Controller {

    public function index() {
        return view("Report.Commercial.init");
    }

}
