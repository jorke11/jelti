<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller {

    public function index() {
        return view("Report.Product.init");
    }

}
