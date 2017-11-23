<?php

namespace App\Http\Controllers\Shopping;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Categories;
use App\Models\Administration\Products;
use App\Models\Administration\ProductsImage;
use App\Models\Administration\Comment;
use App\Models\Administration\Characteristic;
use App\Models\Inventory\Orders;
use App\Models\Inventory\OrdersDetail;
use App\Models\Administration\Stakeholder;
use Auth;
use DB;

class ShoppingController extends Controller {

//    public function __construct() {
//        $this->middleware("auth");
//    }

    public function index() {
        return view("Ecommerce.shopping.init");
    }

    public function getDetailProduct($id) {

        if (strpos($id, "_") !== false) {

            $id = str_replace("_", "", $id);

            $category = Categories::find($id);

            $products = DB::table("vproducts")->where(DB::raw("characteristic->>0"), $id)->whereNotNull("image")->paginate(10);
        } else {

            $category = Categories::find($id);


            $products = DB::table("vproducts")->where("category_id", $id)->whereNotNull("image")->paginate(10);
        }
        
        foreach ($products as $i => $value) {
            $cod = str_replace("]", "", str_replace("[", "", $products[$i]->characteristic));
            $cod = explode(",", $cod);
            $cod = array_filter($cod);

            if (count($cod) > 0) {
                $cha = Characteristic::whereIn("id", $cod)->get();
                $products[$i]->characteristic = $cha;
            }
        }
        
      

        
        $subcategory = Characteristic::where("status_id", 1)->where("type_subcategory_id", 1)->orderBy("order", "asc")->get();

//        dd($subcategory);
        return view("Ecommerce.shopping.detail", compact("products", "category", "subcategory"));
    }

    public function getCategories() {
        return Categories::all();
    }

    public function getProduct($id) {
        $product = DB::table("vproducts")->where("id", $id)->first();

        $detail = ProductsImage::where("product_id", $id)->get();
        $relations = DB::table("vproducts")->where("category_id", $product->category_id)->whereNotNull("image")->get();
        $supplier = Stakeholder::find($product->supplier_id);
//         dd($relations);
        return view("Ecommerce.shopping.product", compact("product", "detail", "relations", "supplier"));
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
        $data["value"] = $pro["price_sf"];
        OrdersDetail::create($data);

        return $this->getDataCountOrders();
    }

    public function getCountOrders() {
        $count = 0;

        if (Auth::user() != null) {
            $count = $this->getDataCountOrders();
        }

        return response()->json(["quantity" => $count]);
    }

    public function getDataCountOrders() {
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
