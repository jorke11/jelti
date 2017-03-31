<?php

namespace App\Http\Controllers\Shopping;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Categories;
use App\Models\Administration\Products;
use App\Models\Administration\ProductsImage;
use App\Models\Administration\Comment;
use App\Models\Inventory\Orders;
use App\Models\Inventory\OrdersDetail;
use Auth;
use DB;

class ShoppingController extends Controller {

    public function __construct() {
        $this->middleware("auth");
    }

    public function index() {
        return view("Ecommerce.shopping.init");
    }

    public function getDetailProduct($id) {
        $products = Products::where("category_id", $id)->get();
        return view("Ecommerce.shopping.detail", compact("products"));
    }

    public function getCategories() {
        return Categories::all();
    }

    public function getProduct($id) {
        $product = Products::findOrFail($id);
        $detail = ProductsImage::where("product_id", $id)->get();
        return view("Ecommerce.shopping.product", compact("product", "detail"));
    }

    public function addComment(Request $req) {
        $data = $req->all();
        $data["stakeholder_id"] = Auth::user()->id;
        Comment::create($data);
        $detail = $this->getComment($data["product_id"]);
        return response()->json($detail);
    }

    public function managementOrder(Request $req) {
        $data = $req->all();

        $order = Orders::where("stakeholder_id", Auth::user()->id)->where("status_id", 1)->first();
        if (count($order) > 0) {
            $order_id = $order["id"];
        } else {
            $new["stakeholder_id"] = Auth::user()->id;
            $new["status_id"] = 1;
            $order_id = Orders::create($new)->id;
        }


        $pro = Products::findOrFail($data["product_id"]);
        $data["order_id"] = $order_id;
        $data["tax"] = $pro["tax"];
        $data["value"] = $pro["price_cust"];
        OrdersDetail::create($data);

        return $this->getCountOrders();
    }

    public function getCountOrders() {
        $order = Orders::where("stakeholder_id", Auth::user()->id)->where("status_id", 1)->first();
        return OrdersDetail::where("order_id", $order["id"])->sum("quantity");
    }

    public function getComment($product_id) {
        return DB::table("comments")
                        ->select("comments.description", "stakeholder.name", "comments.created_at")
                        ->join("stakeholder", "stakeholder.id", "comments.stakeholder_id")
                        ->where("product_id", $product_id)
                        ->orderBy("comments.id", "DESC")
                        ->get();
    }

}