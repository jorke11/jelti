<?php

namespace App\Http\Controllers\Administration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\Models\Administration;
use Input;
use DB;
use App\Models\Administration\Products;
use App\Models\Administration\ProductsImage;

class ProductController extends Controller {

    public function index() {
        $categories = Administration\Categories::all();
        $suppliers = Administration\Suppliers::all();
        return view("products.init", compact("categories", "suppliers"));
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["product_id"]);
//            $user = Auth::User();
//            $input["users_id"] = 1;
            $input["status"] = (isset($input["status"])) ? 1 : 0;

            $result = Products::create($input);
            if ($result) {
                Session::flash('save', 'Se ha creado correctamente');
                return response()->json(['success' => 'true']);
            } else {
                return response()->json(['success' => 'false']);
            }
        }
    }

    public function edit($id) {
        $resp["header"] = Products::FindOrFail($id);
        $resp["images"] = ProductsImage::where("product_id", $id)->get();

        return response()->json($resp);
    }

    public function update(Request $request, $id) {
        $product = Products::FindOrFail($id);
        $input = $request->all();
        $input["status"] = (isset($input["status"])) ? 1 : 0;

        $result = $product->fill($input)->save();
        if ($result) {
            Session::flash('save', 'Se ha creado correctamente');
            return response()->json(['success' => 'true']);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

    public function destroy($id) {
        $product = Products::FindOrFail($id);
        $result = $product->delete();
        Session::flash('delete', 'Se ha eliminado correctamente');
        if ($result) {
            Session::flash('save', 'Se ha creado correctamente');
            return response()->json(['success' => 'true']);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

    public function uploadImage(Request $req) {
        $data = $req->all();
        $file = array_get($data, 'kartik-input-700');
        $name = $file[0]->getClientOriginalName();
        $file[0]->move("images/product/" . $data["product_id"], $name);

        ProductsImage::where("product_id", $data["product_id"])->get();
        $product = new ProductsImage();
        $product->product_id = $data["product_id"];
        $product->path = $data["product_id"] . "/" . $name;
        $product->main = true;

        $product->save();
        return response()->json(["id" => $data["product_id"]]);
    }

    public function checkmain(Request $data, $id) {
        $input = $data->all();
        $product = Products::find($input["product_id"]);
        DB::table("productimage")->where("product_id", $input["product_id"])->update(['main' => false]);
        $image = ProductsImage::where("id", $id)->update(['main' => true]);
        $image = ProductsImage::find($id);
        $product->image = $image->path;
        $product->save();
        return response()->json(["response" => true, "path" => $image]);
    }

    public function deleteImage(Request $data, $id) {
        $image = ProductsImage::find($id);
        $image->delete();
        ProductsImage::where("product_id", $data["product_id"]);
        return response()->json(["response" => true, "path" => $data->all()]);
    }

    public function getImages($id) {
        $image = ProductsImage::where("product_id", $id)->get();
        return response()->json($image);
    }

}
