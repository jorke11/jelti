<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProspectsController extends Controller
{
    public function index(){
        return view("Sellers.prospect.init");
    }
}
