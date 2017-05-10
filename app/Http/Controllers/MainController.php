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

    public function listComments(Request $req, $id) {
        $date = $req->all();

        $sent = \DB::table("comments")
                ->select("comments.id", "products.title as product", "users.name as stakeholder", "comments.created_at", "comments.description")
                ->join("products", "products.id", "comments.product_id")
                ->join("users", "users.id", "comments.stakeholder_id")
                ->whereBetween('comments.created_at', array($date["finit"], $date["fend"]));

        if ($id == 0) {
            return $sent->get();
        } else {
            return $sent->where("products.id", $id)->get();
        }
    }

}
