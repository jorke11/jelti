<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Administration\Products;
use App\Models\Administration\Comment;
use Illuminate\Support\Facades\Auth;
//use DB;
class MainController extends Controller {

    public function __construct() {
        $this->middleware("auth");
    }

    public function getComments() {
        $products = Products::where("supplier_id", Auth::User()->id)->get();
        return view("Main.comment", compact("products"));
    }

    public function listComments() {
        return \DB::table("comments")
                ->join("products","products.id","comments.product_id")->get();
    }
    
   

}
