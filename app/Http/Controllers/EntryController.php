<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EntryController extends Controller
{
   public function index(){
       return view("entry.init");
   }
   
   public function getConsecutive($id){
       
       echo response()->json(["response"=>'prueba']);
   }
   
}
