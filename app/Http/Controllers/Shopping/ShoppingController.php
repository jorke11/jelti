<?php
namespace App\Http\Controllers\Shopping;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Categories;
use App\Models\Administration\Products;
use App\Models\Administration\ProductsImage;

class ShoppingController extends Controller {

    public function index() {
        return view("shopping.init");
    }

    public function getDetailProduct($id) {
        $products = Products::where("category_id", $id)->get();
        return view("shopping.detail", compact("products"));
    }

    public function getCategories() {
        return Categories::all();
    }

    public function getProduct($id) {
        $product = Products::findOrFail($id);
        $detail = ProductsImage::where("product_id", $id)->get();
        return view("shopping.product", compact("product", "detail"));
    }

}
