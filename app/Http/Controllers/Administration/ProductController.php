<?php

namespace App\Http\Controllers\Administration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\Models\Administration;
use Input;

class ProductController extends Controller {

    public function index() {
        $categories = Administration\Category::all();
        $suppliers = Administration\Supplier::all();
        return view("products.init", compact("categories", "suppliers"));
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);
//            $user = Auth::User();
//            $input["users_id"] = 1;
            $result = Administration\Product::create($input);
            if ($result) {
                Session::flash('save', 'Se ha creado correctamente');
                return response()->json(['success' => 'true']);
            } else {
                return response()->json(['success' => 'false']);
            }
        }
    }

    public function edit($id) {
        $resp["header"] = Administration\Product::FindOrFail($id);
        $resp["images"] = Administration\Productimage::where("product_id", $id)->get();

        return response()->json($resp);
    }

    public function update(Request $request, $id) {
        $product = Administration\Product::FindOrFail($id);
        $input = $request->all();
        $result = $product->fill($input)->save();
        if ($result) {
            Session::flash('save', 'Se ha creado correctamente');
            return response()->json(['success' => 'true']);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

    public function destroy($id) {
        $product = Administration\Product::FindOrFail($id);
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

        Administration\Productimage::where("product_id", $data["product_id"])->get();
        $product = new Administration\Productimage();
        $product->product_id = $data["product_id"];
        $product->path = $data["product_id"] . "/" . $name;
        $product->main = true;

        $product->save();
        return response()->json(["id" => $data["product_id"]]);
    }

    public function checkmain(Request $data, $id) {
        $input = $data->all();
        $product = Administration\Product::find($input["product_id"]);
        \Illuminate\Support\Facades\DB::table("productimage")->where("product_id", $input["product_id"])->update(['main' => false]);
        $image = Administration\Productimage::where("id", $id)->update(['main'=>true]);
        $image = Administration\Productimage::find($id);
        $product->image=$image->path;
        $product->save();
        return response()->json(["response"=>true,"path"=>$image]);
        
    }
    public function deleteImage(Request $data, $id) {
        $image = Administration\Productimage::find($id);
        $image->delete();
        Administration\Productimage::where("product_id",$data["product_id"]);
        return response()->json(["response"=>true,"path"=>$data->all()]);
        
    }
    
    public function getImages($id){
        $image= Administration\Productimage::where("product_id",$id)->get();
        return response()->json($image);
    }

}
