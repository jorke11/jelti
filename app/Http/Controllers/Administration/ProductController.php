<?php

namespace App\Http\Controllers\Administration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\Models\Administration;
use App\Models\Administration\PriceSpecial;
use Input;
use DB;
use App\Models\Administration\Products;
use App\Models\Administration\ProductsImage;
use Datatables;
use App\Http\Requests\Administration\ProductsCreateRequest;
use App\Http\Requests\Administration\ProductsUpdateRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Uploads\Base;

class ProductController extends Controller {

    public $name;
    public $path;

    public function __construct() {
        $this->middleware("auth");
        $this->name = '';
        $this->path = '';
    }

    public function index() {
        return view("Administration.products.init");
    }

    public function store(ProductsCreateRequest $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);
//            $user = Auth::User();
//            $input["users_id"] = 1;

            if (isset($input["characteristic"])) {
                $input["characteristic"] = json_encode($input["characteristic"]);
            }

            $input["status"] = (isset($input["status"])) ? 1 : 0;

            $result = Products::create($input)->id;

            if ($result) {
                $product = Products::FindOrFail($result);
                return response()->json(['success' => true, 'header' => $product]);
            } else {
                return response()->json(['success' => false]);
            }
        }
    }

    public function storeSpecial(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);

            $result = PriceSpecial::create($input);
            if ($result) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false]);
            }
        }
    }

    public function storeExcel(Request $request) {
        if ($request->ajax()) {
            
            $input = $request->all();
            $this->name = '';
            $this->path = '';
            $file = array_get($input, 'file_excel');
            $this->name = $file->getClientOriginalName();
            $this->name = str_replace(" ", "_", $this->name);
            $this->path = "uploads/products/" . date("Y-m-06") . "/" . $this->name;

//            $file->move("uploads/products/" . date("Y-m-d"), $name);
            Excel::load($this->path, function($reader) {
//                $in["name"] = $this->name;
//                $in["path"] = $this->path;
//                $in["quantity"] = count($reader->get());
//
//                $base_id = Base::create($in)->id;
                
//                dd($reader->get());
                var_dump($reader->get());
                
//                foreach ($reader->get() as $book) {
//                    dd($book);
//                }
            })->get();
     
           echo "fin";exit;
        }
    }

    public function getSpecial(Request $req) {
        $in = $req->all();
        return Datatables::eloquent(PriceSpecial::where("product_id", $in["product_id"]))->make(true);
    }

    public function edit($id) {

        $resp["header"] = Products::FindOrFail($id);
        $resp["images"] = ProductsImage::where("product_id", $id)->get();
        return response()->json($resp);
    }

    public function update(Request $request, $id) {
        $product = Products::FindOrFail($id);
        $input = $request->all();

        if (isset($input["characteristic"])) {
            $input["characteristic"] = json_encode($input["characteristic"]);
        }

        $input["status"] = (isset($input["status"])) ? 1 : 0;

        $result = $product->fill($input)->save();
        if ($result) {
            $product = Products::FindOrFail($id);
            return response()->json(['success' => true, 'header' => $product]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function destroy($id) {
        $product = Products::FindOrFail($id);
        $result = $product->delete();
        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function uploadImage(Request $req) {
        $data = $req->all();
        $file = array_get($data, 'kartik-input-700');
        $name = $file[0]->getClientOriginalName();
        $file[0]->move("images/product/" . $data["id"], $name);

        ProductsImage::where("product_id", $data["id"])->get();
        $product = new ProductsImage();
        $product->product_id = $data["id"];
        $product->path = $data["id"] . "/" . $name;
        $product->main = true;

        $product->save();
        return response()->json(["id" => $data["id"]]);
    }

    public function checkmain(Request $data, $id) {
        $input = $data->all();
        $product = Products::find($input["product_id"]);
        DB::table("products_image")->where("product_id", $input["product_id"])->update(['main' => false]);
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
