<?php

namespace App\Http\Controllers\Suppliers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Parameters;
use Auth;
use App\Models\Administration\Products;

class ServicesController extends Controller {

    public $name;
    public $path;
    public $inserted;
    public $updated;

    public function __construct() {
        $this->middleware("auth");
        $this->name = '';
        $this->path = '';
        $this->inserted = '';
        $this->updated = '';
    }

    public function index() {
        $tax = Parameters::where("group", "tax")->whereIn("code", array(3, 4, 5))->get();
        return view("Suppliers.services.init", compact("tax"));
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);

            $input["users_id"] = Auth::User()->id;

            if (isset($input["characteristic"])) {
                $input["characteristic"] = json_encode($input["characteristic"]);
            }

            $input["status_id"] = (isset($input["status_id"])) ? 1 : 2;
            $input["type_product_id"] = 1;
            $input["category_id"] = -1;
            $input["reference"] = strtotime(date("Y-m-d H:i:s"));
            $input["units_supplier"] = 1;
            $input["units_sf"] = 1;
            $input["cost_sf"] = 0;
            $input["bar_code"] = strtotime(date("Y-m-d H:i:s"));

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

            Excel::load($this->path, function($reader) {
                $in["name"] = $this->name;
                $in["path"] = $this->path;
                $in["quantity"] = count($reader->get());

                $base_id = Base::create($in)->id;

                foreach ($reader->get() as $book) {

                    if (trim($book->supplier) != '' && trim($book->category) != '') {

                        $sup = Administration\Stakeholder::where("business", "ILIKE", trim($book->supplier))->first();
                        $cat = Administration\Categories::where("description", "like", trim($book->category))->first();

                        if (count($sup) > 0 && count($cat) > 0) {

                            $book->ean = (!isset($book->ean)) ? '' : trim($book->ean);
                            $product["category_id"] = $cat->id;
                            $product["supplier_id"] = $sup->id;
                            $product["stakeholder_id"] = $sup->id;
                            $product["account_id"] = 1;
                            $product["title"] = trim($book->title);
                            $product["short_description"] = trim($book->title);
                            $product["description"] = trim($book->title);
                            $product["reference"] = (int) trim($book->sf_code);
                            $product["bar_code"] = (int) trim($book->ean);
                            $product["tax"] = trim($book->tax);
                            $product["units_supplier"] = (int) trim($book->supplier_packing);
                            $product["units_sf"] = (int) trim($book->sf_packing);
                            $product["cost_sf"] = trim($book->unit_cost);
                            $product["price_sf"] = trim($book->sf_price);
                            $product["status_id"] = 2;
                            $product["margin_sf"] = (double) trim($book->sf_margin);
                            $product["margin"] = trim($book->margen);
                            $product["status_id"] = 3;
                            $product["minimum_stock"] = 15;

                            $pro = Products::where("reference", $product["reference"])->first();

                            if (count($pro) > 0) {

                                $pro->fill($product)->save();
                                $this->updated++;
                            } else {
                                Products::create($product);
                                $this->inserted++;
                            }
                        }
                    }
                }
            })->get();

            return response()->json(["success" => true, "data" => Products::where("status_id", 3)->get(), "inserted" => $this->inserted, "updated" => $this->updated]);
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
        return response()->json($resp);
    }

    public function update(Request $request, $id) {
        $product = Products::FindOrFail($id);
        $input = $request->all();

        if (isset($input["characteristic"])) {
            $input["characteristic"] = json_encode($input["characteristic"]);
        }
        $input["update_id"] = Auth::User()->id;

        $input["status_id"] = (isset($input["status_id"])) ? 1 : 2;
        $input["packaging"] = 1;

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
