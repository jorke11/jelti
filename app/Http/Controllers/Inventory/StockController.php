<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Dompdf\Adapter\PDFLib;
use Datatables;
use PDF;

class StockController extends Controller {

    public function index() {
        return view("stock.init");
    }

    public function getStock() {
        return Datatables::queryBuilder(DB::table("vstock"))->make(true);
    }

}
