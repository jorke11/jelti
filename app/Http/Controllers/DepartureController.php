<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DepartureController extends Controller
{
    public function index(){
       return view("departure.init");
   }
}
