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
use Auth;

class ProductController extends Controller {

    public $name;
    public $path;
    public $inserted;
    public $insertedArray;
    public $updated;
    public $response;

    public function __construct() {
        $this->middleware("auth");
        $this->name = '';
        $this->path = '';
        $this->inserted = '';
        $this->updated = '';
    }

    public function index() {
        $tax = Administration\Parameters::where("group", "tax")->whereIn("code", array(3, 4, 5))->get();
        return view("Administration.products.init", compact("tax"));
    }

    public function store(ProductsCreateRequest $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);
//            $user = Auth::User();
            $input["users_id"] = Auth::User()->id;

            if (isset($input["characteristic"])) {
                $input["characteristic"] = json_encode($input["characteristic"]);
            }


            if (isset($input["characteristic"])) {
                $input["characteristic"] = json_encode($input["characteristic"]);
            }
            if (isset($input["warehouse"])) {

                $input["warehouse"] = json_encode($input["warehouse"]);
            }

            if ($input["pvp"] == '') {
                unset($input["pvp"]);
            }


            $input["packaging"] = ($input["packaging"] == '') ? 0 : $input["packaging"];


            $input["status_id"] = (isset($input["status_id"])) ? 1 : 2;

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
            $this->path = "uploads/products/" . date("Y-m-d") . "/" . $this->name;

            $file->move("uploads/products/" . date("Y-m-d") . "/", $this->name);

            $this->response = array();

            Excel::load($this->path, function($reader) {
                $in["name"] = $this->name;
                $in["path"] = $this->path;
                $in["quantity"] = count($reader->get());

                $base_id = Base::create($in)->id;

                foreach ($reader->get() as $book) {

                    if ($book->sf_code) {
//                        dd($book);
                        
//                        $pro = Products::where("reference", $book->sf_code)->where("status_id", 1)->first();
                        $pro = Products::where("reference", $book->sf_code)->first();

                        if ($pro != null) {

//                            $pro->price_sf = $book->sf_code;

                            if (isset($book->title) && $book->title != '') {
                                $pro->title = $book->title;
                            }
                            if (isset($book->tax) && $book->tax != '') {
                                $pro->tax = $book->tax;
                            }
                            if (isset($book->unit_sf_price_sin_iva) && $book->unit_sf_price_sin_iva != '') {
                                $pro->price_sf = round($book->unit_sf_price_sin_iva);
                            }
                            if (isset($book->costo_unitario_sin_iva) && $book->costo_unitario_sin_iva != '') {
                                $pro->cost_sf = round($book->costo_unitario_sin_iva);
                            }
                            if (isset($book->unit_pvp_sugerido_sf_iva) && $book->unit_pvp_sugerido_sf_iva != '') {
                                $pro->pvp = round($book->unit_pvp_sugerido_sf_iva);
                            }

                            if (isset($book->estatus) && $book->estatus != '') {
                                $status = 0;
                                if ($book->estatus == 'si') {
                                    $pro->status_id = 1;
                                } else {
                                    $pro->status_id = 2;
                                }
                            }


                            $this->response[] = array("sf_code" => $book->sf_code, "title" => $book->title, "price_sf" => $pro->price_sf, "cost_sf" => $pro->cost_sf, "msg" => "Actualizado", "status" => false);

                            $pro->save();
                        } else {
                            $this->response[] = array("sf_code" => $book->sf_code, "title" => $book->title, "msg" => "No existe o inactivo", "status" => false);
                        }
                    }
                }
            })->get();

            return response()->json(["success" => true, "data" => $this->response]);
        }
    }

    public function storeExcelCode(Request $request) {
        if ($request->ajax()) {

            $input = $request->all();

            $this->name = '';
            $this->path = '';
            $file = array_get($input, 'file_excel');
            $this->name = $file->getClientOriginalName();
            $this->name = str_replace(" ", "_", $this->name);
            $this->path = "uploads/products/" . date("Y-m-d") . "/" . $this->name;

            $file->move("uploads/products/" . date("Y-m-d") . "/", $this->name);

            Excel::load($this->path, function($reader) {

                foreach ($reader->get() as $book) {
                    if (trim($book->sf_code) != '') {

                        $pro = Products::where("reference", $book->sf_code)->first();
                        if (count($pro) > 0) {
                            $pro->alias_reference = $book->item;
                            $pro->save();
                            $this->updated++;
                        } else {
                            Products::create($product);
                            $this->inserted++;
                        }
                    }
                }
            })->get();

            return response()->json(["success" => true, "data" => Products::where("status_id", 3)->get(), "inserted" => $this->inserted, "updated" => $this->updated]);
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
        if (isset($input["warehouse"])) {

            $input["warehouse"] = json_encode($input["warehouse"]);
        }

        if ($input["pvp"] == '') {
            unset($input["pvp"]);
        }

        $input["update_id"] = Auth::User()->id;

        $input["is_new"] = (isset($input["is_new"])) ? 1 : 0;
        $input["status_id"] = (isset($input["status_id"])) ? 1 : 2;
        $input["packaging"] = ($input["packaging"] == '') ? 0 : $input["packaging"];


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
