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
use App\Models\Blog\Feedback;
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


        $subcategory = Characteristic::where("status_id", 1)->whereNotNull("img")->where("type_subcategory_id", 1)->orderBy("order", "asc")->get();

        if ($id == '0') {
            $products = DB::table("vproducts")->whereNotNull("image")->whereNotNull("warehouse")->orderBy("title", "desc")->paginate(16);
            $category = Categories::all();
            return view("Ecommerce.shopping.specific", compact("category", "products", "subcategory"));
        } else {

            if (strpos($id, "_") !== false) {

                $id = str_replace("_", "", $id);

                $category = Categories::find($id);

                $products = DB::table("vproducts")->where(DB::raw("characteristic->>0"), $id)->whereNotNull("image")->whereNotNull("warehouse")->orderBy("title", "desc")->paginate(12);


                return view("Ecommerce.shopping.specific", compact("category", "products", "subcategory"));
            } if (strpos($id, "sub") !== false) {
                $id = str_replace("sub", "", $id);

                $category = Categories::find($id);

                $products = DB::table("vproducts")->where("category_id", $id)->whereNotNull("image")->whereNotNull("warehouse")->orderBy("title", "desc")->paginate(12);


                return view("Ecommerce.shopping.specific", compact("category", "products", "subcategory"));
            } else {

                $category = Categories::find($id);

                $categoryAssoc = Categories::where("node_id", $id)->get();
                $in = [];

                $sub = array();

                foreach ($categoryAssoc as $j => $value) {

                    $products = DB::table("vproducts")->where("category_id", $value->id)->whereNotNull("image")->orderBy("supplier_id")->orderBy("title", "desc")->get();

                    foreach ($products as $i => $value) {
                        $cod = str_replace("]", "", str_replace("[", "", $products[$i]->characteristic));
                        $cod = array_map('intval', explode(",", $cod));
                        $cod = array_filter($cod);


                        if (count($cod) > 0) {

                            foreach ($cod as $value) {

                                if (!in_array($value, $sub)) {

                                    $sub[] = $value;
                                }
                            }

                            $cha = Characteristic::whereIn("id", $cod)->get();
                            if (count($cha) == 0) {
                                $cha = null;
                            }

                            $products[$i]->characteristic = $cha;
                        } else {
                            $products[$i]->characteristic = null;
                        }

                        $products[$i]->short_description = str_replace("/", "<br>", $products[$i]->short_description);
                    }

                    $categoryAssoc[$j]->products = $products;
                }

                $subcategory = Characteristic::where("status_id", 1)->whereNotNull("img")->where("type_subcategory_id", 1)->whereIn("id", $sub)->orderBy("order", "asc")->get();


                return view("Ecommerce.shopping.detail", compact("category", "categoryAssoc", "subcategory", "id"));
            }
        }
    }

    public function getDetailProductAllCategory($id, $subcategory_id) {
        $category = Categories::find($id);

        $subcategory = Characteristic::where("status_id", 1)->whereNotNull("img")->where("type_subcategory_id", 1)->where("id", $subcategory_id)->orderBy("order", "asc")->get();


        $products = DB::table("vproducts")->where("category_id", $id)->where(DB::raw("characteristic->>0"), $subcategory_id)
                        ->whereNotNull("image")->whereNotNull("warehouse")->orderBy("title", "desc")->paginate(12);

        return view("Ecommerce.shopping.specific", compact("category", "products", "subcategory"));
    }

    public function getDetailProductFilter($category_id, $subcategory_id) {


        $subcategory = Characteristic::where("status_id", 1)->whereNotNull("img")->where("type_subcategory_id", 1)->where("id", $subcategory_id)->orderBy("order", "asc")->get();

        $category = Categories::find($category_id);

//        dd($subcategory);

        $categoryAssoc = Categories::where("node_id", $category_id)->get();
        $in = [];

        foreach ($categoryAssoc as $j => $value) {

            $products = DB::table("vproducts")->where("category_id", $value->id)->whereNotNull("image")->where(DB::raw("characteristic->>0"), $subcategory_id)->orderBy("supplier_id")->orderBy("title", "desc")->get();

            foreach ($products as $i => $value) {
                $cod = str_replace("]", "", str_replace("[", "", $products[$i]->characteristic));
                $cod = array_map('intval', explode(",", $cod));
                $cod = array_filter($cod);

                if (count($cod) > 0) {

                    $cha = Characteristic::whereIn("id", $cod)->get();
                    if (count($cha) == 0) {
                        $cha = null;
                    }
                    $products[$i]->characteristic = $cha;
                } else {
                    $products[$i]->characteristic = null;
                }

                $products[$i]->short_description = str_replace("/", "<br>", $products[$i]->short_description);
            }

            $categoryAssoc[$j]->products = $products;
        }

        $id = $category_id;

        return view("Ecommerce.shopping.detail", compact("category", "categoryAssoc", "subcategory", "subcategory_id", "id"));
    }

    public function getCategories() {
        return Categories::all();
    }

    public function getProduct($id) {
        $product = DB::table("vproducts")->where("id", $id)->first();


        if ($product != null) {

            $detail = ProductsImage::where("product_id", $id)->get();

            $relations = DB::table("vproducts")->where("category_id", $product->category_id)->whereNotNull("image")->get();


            $supplier = Stakeholder::find($product->supplier_id);

            if ($product->characteristic != null) {
                $cod = json_decode($product->characteristic, true);
                $id = array();

                foreach ($cod as $value) {
                    $id[] = (int) $value;
                }

                if (count($id) > 0) {
                    $cha = Characteristic::whereIn("id", $cod)->get();
                    $product->characteristic = $cha;
                }
            }



            return view("Ecommerce.shopping.product", compact("product", "detail", "relations", "supplier"));
        } else {
            return response(view('errors.503'), 404);
        }
    }

    public function addComment(Request $req) {
        $data = $req->all();

//        dd($data);
        $data["user_id"] = Auth::user()->id;
        $data["type_id"] = 1;
        $data["row_id"] = $data["product_id"];
        Feedback::create($data);
        return $this->getComment($data["product_id"]);
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
        $data["units_sf"] = $pro["units_sf"];
        $data["packaging"] = $pro["packaging"];
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
        $feed = Feedback::select("feedback.id", "feedback.title", "users.name", "users.last_name", "feedback.content", "feedback.created_at")
                        ->join("users", "users.id", "feedback.user_id")
                        ->where("row_id", $product_id)->get();

        return response()->json($feed);
    }

}
