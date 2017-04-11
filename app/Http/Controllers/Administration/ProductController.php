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
            $this->path = "uploads/products/" . date("Y-m-d") . "/" . $this->name;

            $file->move("uploads/products/" . date("Y-m-d") . "/", $this->name);

//              "category" => "Snacks"
//    "supplier" => "Granolitas"
//    "sf_code" => 100001.0
//    "ean" => 7708991332065.0
//    "title" => "Granolitas Horneadas 30 g (10 unidades)"
//    "supplier_packing" => 50.0
//    "sf_packing" => 1.0
//    "catalog" => true
//    "tax" => 0.19
//    "unit_cost" => 16000.0
//    "cost_tax" => 19040.0
//    "sf_price" => 19700.0
//    "sp_price_tax" => 23443.0
//    "sf_margin" => 0.1878172588832487
//    "pvp_sugerido_sin_iva" => 25210.08403361345
//    "iva" => 0.19
//    "pvp_sugerido_iva" => 30000.0
//    "margen" => 0.2185666666666667
//    "" => null
//    "farmatodo_costo_con_iva" => 22500.0
//    "pvp_farmatodo_con_iva" => 30000.0
//    "margen_farmatodo" => 0.25
//    "sf_recibe" => 22050.0
//    "margen_sf_farmatodo" => 0.1365079365079365
//    "farmatodo_catalogo" => "Activo"
//    "megatiendas_costo" => 23443.0
//    "pvp_megatiendas" => 31500.0
//    "margen_megatiendas" => 0.2557777777777778
//    "margen_sf_megatiendas" => 0.1878172588832487
//    "megatiendas_catalogo" => "Activo"
//    "cruz_verde_costo" => 23626.05
//    "pvp_cruz_verde" => 31500.0
//    "margen_cruz_verde" => 0.2499666666666667
//    "margen_sf_cruz_verde" => 0.1941098914122336
//    "cruz_verde_catalogo" => null
//    "locatel" => 23330
//    "locatel_iva" => 27762.7
//    "margen_locatel" => 0.07457666666666662
//    "margen_sf_locatel" => 0.3141877411058723
//    "paleo" => null
//    "gluten_free" => null
//    "vegan" => "X"
//    "non_gmo" => null
//    "organico" => null
//    "sin_grasa_trans" => "X"
//    "sin_azucar_added" => "X"
//    "delante" => "http://i.imgur.com/CBmZemt.jpg"
//    "atras" => "http://i.imgur.com/TosagWK.jpg"



            Excel::load($this->path, function($reader) {
                $in["name"] = $this->name;
                $in["path"] = $this->path;
                $in["quantity"] = count($reader->get());

                $base_id = Base::create($in)->id;


                foreach ($reader->get() as $book) {

                    if ($book->supplier != '' && $book->category != '') {
                        $sup = Administration\Stakeholder::where("business", "like", $book->supplier)->first();
                        $cat = Administration\Categories::where("description", "like", $book->category)->first();
                        if (count($sup) > 0) {
                            $product["category_id"] = $cat->id;
                            $product["supplier_id"] = $sup->id;
                            $product["stakeholder_id"] = $sup->id;
                            $product["account_id"] = 1;
                            $product["title"] = $book->title;
                            $product["short_description"] = $book->title;
                            $product["description"] = $book->title;
                            $product["reference"] = (int) $book->sf_code;
                            $product["bar_code"] = (int) $book->ean;
                            $product["tax"] = $book->tax;
                            $product["units_supplier"] = (int) $book->supplier_packing;
                            $product["units_sf"] = (int) $book->sf_packing;
                            $product["cost_sf"] = $book->unit_cost;
                            $product["price_sf"] = $book->sf_price;
                            $product["price_cust"] = $book->pvp_sugerido_sin_iva;
                            $product["status_id"] = 2;
                            $product["margin_sf"] = (double) $book->sf_margin;
                            $product["margin"] = $book->margen;
                            $product["status_id"] = 2;

                            $pro = Products::where("reference", $product["reference"])->first();

                            if (count($pro) > 0) {
                                $pro->fill($product)->save();
                            } else {
                                Products::create($product);
                            }
                            var_dump($product);
                        } else {
                            echo "<br>else<br>";
                            var_dump($book->supplier);
                        }
                    }
                }
            })->get();

            return response()->json(["success" => true, "data" => Products::all()]);
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
