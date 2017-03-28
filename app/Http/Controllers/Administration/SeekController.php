<?php

namespace App\Http\Controllers\Administration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Cities;
use App\Models\Administration\Suppliers;
use App\Models\Administration\Stakeholder;
use App\Models\Administration\Warehouses;
use App\Models\Administration\Products;
use App\Models\Administration\Categories;
use App\Models\Administration\Characteristic;
use App\Models\Security\Users;
use Illuminate\Support\Facades\Auth;
use App\Models\Administration\Branch;
use App\Models\Administration\Puc;
use App\Models\Administration\Contact;

class SeekController extends Controller {

    public function getCity(Request $req) {
        $in = $req->all();
        $query = Cities::select("id", "description as text");
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

    public function getClient(Request $req) {
        $in = $req->all();
        $query = Stakeholder::select("id", "name as text");
        if (isset($in["q"]) && $in["q"] == "0") {
            $query->where("id", Auth::user()->supplier_id)->get();
        } else if (isset($in["id"]) && $in["id"] != '') {
            $query->where("id", $in["id"])->get();
        } else {
            if (isset($in["q"]))
                $query->where("name", "ilike", "%" . $in["q"] . "%")->where("type_stakeholder", 1)->get();
        }
        $result = $query->get();

        return response()->json(['items' => $result, "pages" => count($result)]);
    }

    public function getSupplier(Request $req) {
        $in = $req->all();
        $query = Stakeholder::select("id", "name as text");
        if (isset($in["q"]) && $in["q"] == "0") {
            $query->where("id", Auth::user()->supplier_id)->get();
        } else if (isset($in["id"])) {
            $query->where("id", $in["id"])->get();
        } else {
            $query
                    ->where("name", "ilike", "%" . $in["q"] . "%")
                    ->where("type_stakeholder", 2)
                    ->get();
        }
        $result = $query->get();

        return response()->json(['items' => $result, "pages" => count($result)]);
    }

    public function getStakeholder(Request $req) {
        $in = $req->all();
        $query = Stakeholder::select("id", "name as text");
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

    public function getCharacteristic(Request $req) {
        $in = $req->all();
        $query = Characteristic::select("id", "description as text");
        if (isset($in["q"]) && $in["q"] == "0") {
            $query->where("id", Auth::user()->supplier_id)->get();
        } else if (isset($in["id"])) {
            if ($in["id"] != '') {
                $in["id"] = json_decode($in["id"]);
                if (count($in["id"]) > 1) {
                    $query->whereIn("id", $in["id"])->get();
                } else {
                    $query->where("id", $in["id"])->get();
                }
            } else {
                $query->where("id", 0)->get();
            }
        } else {
            $query->where("description", "ilike", "%" . $in["q"] . "%")->get();
        }
        $result = $query->get();

        return response()->json(['items' => $result, "pages" => count($result)]);
    }

    public function getWarehouse(Request $req) {
        $in = $req->all();
        $query = Warehouses::select("id", "description as text");
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

    public function getCategory(Request $req) {
        $in = $req->all();
        $query = Categories::select("id", "description as text");
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

    public function getCommercial(Request $req) {
        $in = $req->all();
        $query = Users::select("id", "name as text");
        if (isset($in["q"]) && $in["q"] == "0") {
            $query->where("id", Auth::user()->warehouse_id)->get();
        } else if (isset($in["id"]) && $in["id"] != '') {
            $query->where("id", $in["id"]);
        } else {
            if (isset($in["q"]))
                $query->where("name", "ilike", "%" . $in["q"] . "%")->where("role_id", 4)->get();
        }
        $result = $query->get();

        return response()->json(['items' => $result, "pages" => count($result)]);
    }

    public function getResponsable(Request $req) {
        $in = $req->all();
        $query = Users::select("id", "name as text");
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

    public function getContact(Request $req) {
        $in = $req->all();
        $query = Contact::select("id", "name as text");
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
        $query = Products::select("id", "title as text");

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

    public function getBranch(Request $req) {
        $in = $req->all();
        $query = Branch::select("id", "address as text");
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

    public function getAccount(Request $req) {
        $in = $req->all();
        $query = Puc::select("id", "account as text");
        if (isset($in["q"]) && $in["q"] == "0") {
            $query->where("id", Auth::user()->warehouse_id)->get();
        } else if (isset($in["id"])) {
            if ($in["id"] != '') {
                $query->where("id", $in["id"]);
            }
        } else {
            $query->where("account", "ilike", "%" . $in["q"] . "%")->get();
        }
        $result = $query->get();

        return response()->json(['items' => $result, "pages" => count($result)]);
    }

}
