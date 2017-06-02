<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientController extends Controller {

    public function index() {
        return view("Report.Client.init");
    }

}
