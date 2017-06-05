<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SupplierController extends Controller {

    public function index() {
        return view("Report.Supplier.init");
    }

}
