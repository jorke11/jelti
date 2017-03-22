<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Administration\Products;
use Illuminate\Support\Facades\Auth;


class MainController extends Controller {

    public function getComments() {
        $products = Products::where("supplier_id", Auth::User()->id)->get();
        return view("Main.comment",compact("products"));
    }

}
