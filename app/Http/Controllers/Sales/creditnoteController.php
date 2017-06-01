<?php

namespace App\Http\Controllers\Sales;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Categories;
use App\Models\Administration\Parameters;

class creditnoteController extends Controller {

    public function index() {
        $category = Categories::all();
        $status = Parameters::where("group", "departure")->get();
        return view("Sales.CreditNote.init", compact("category", "status"));
    }

}
