<?php

namespace App\Http\Controllers\Invoicing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SummaryController extends Controller {

    public function index() {
    
        return view("Invoicing.summary.init");
    }

}
