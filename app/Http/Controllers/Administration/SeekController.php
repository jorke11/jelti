<?php

namespace App\Http\Controllers\Administration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\City;
use App\Models\Administration\Supplier;
use App\Models\Administration\Warehouse;
use App\Models\Administration\Product;
use App\Models\Security\User;
use Illuminate\Support\Facades\Auth;

class SeekController extends Controller {

    public function getCity(Request $req) {
        $in = $req->all();
        $query = City::select("id", "description");
        if (isset($in["q"]) && $in["q"] == "0") {
            $query->where("id", Auth::user()->city_id)->get();
        } else if (isset($in["id"])) {
            $query->where("id", $in["id"])->get();
        } else {
            $query->where("description", "ilike", "%" . $in["q"] . "%")->get();
        }

        $result = $query->get();

        return response()->json(['items' => $result, "pages" => count($result)]);
    }

    public function getSupplier(Request $req) {
        $in = $req->all();
        $query = Supplier::select("id", "name as description");
        if (isset($in["q"]) && $in["q"] == "0") {
            $query->where("id", Auth::user()->supplier_id)->get();
        } else if (isset($in["id"])) {
            $query->where("id", $in["id"])->get();
        } else {
            $query->where("name", "ilike", "%" . $in["q"] . "%")->get();
        }
        $result = $query->get();

        return response()->json(['items' => $result, "pages" => count($result)]);
    }

    public function getWarehouse(Request $req) {
        $in = $req->all();
        $query = Warehouse::select("id", "description");
        if (isset($in["q"]) && $in["q"] == 0) {
            $query->where("id", Auth::user()->warehouse_id)->get();
        } else if (isset($in["id"])) {
            $query->where("id", $in["id"]);
        } else {
            $query->where("description", "ilike", "%" . $in["q"] . "%")->get();
        }
        $result = $query->get();

        return response()->json(['items' => $result, "pages" => count($result)]);
    }

    public function getResponsable(Request $req) {
        $in = $req->all();
        $query = User::select("id", "name as description");
        if (isset($in["q"]) && $in["q"] == "0") {
            $city = $query->where("id", Auth::user()->id)->get();
        } else if (isset($in["id"])) {
            $query->where("id", $in["id"])->get();
        } else {
            $query->where("name", "ilike", "%" . $in["q"] . "%")->get();
        }
        $result = $query->get();

        return response()->json(['items' => $result, "pages" => count($result)]);
    }

    public function getProduct(Request $req) {
        $in = $req->all();
        $query = Product::select("id", "title as description");

        if (isset($in["filter"]) && $in["filter"] != '') {
            foreach ($in["filter"] as $key => $val) {
                $query->where($key, $val);
            }
        } else if (isset($in["id"])) {
            $query->where("id", $in["id"])->get();
        }

        $result = $query->get();

        return response()->json(['items' => $result, "pages" => count($result)]);
    }

}
