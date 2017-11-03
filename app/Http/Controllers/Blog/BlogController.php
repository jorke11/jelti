<?php

namespace App\Http\Controllers\Blog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Administration\Characteristic;

class BlogController extends Controller {

    public function index() {
        $data = Blog\Content::paginate(10);
        return view("Blog.content.init", compact("data"));
    }

    public function getDetail($id) {
        $data = Blog\Content::find($id);
        return view("Blog.content.detail", compact("data"));
    }

    public function listProducts() {
        $products = \App\Models\Administration\Products::paginate();
        $subcategory = Characteristic::where("status_id", 1)->where("type_subcategory_id", 1)->orderBy("order", "asc")->get();
        
        return view("Blog.content.listproduct", compact("products","subcategory"));
    }

}
