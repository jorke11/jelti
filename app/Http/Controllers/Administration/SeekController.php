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
use App\Models\Administration\Parameters;
use App\Models\Administration\Department;
use DB;
use Log;

class SeekController extends Controller {

    public $input;

    public function __construct() {
        $this->middleware("auth");
    }

    public function getCity(Request $req) {
        $in = $req->all();
        $query = Cities::select("cities.id", DB::raw("initcap(cities.description || ' '||departments.description) as text"))
                ->join("departments", "departments.id", "cities.department_id");
        if (count($in) > 0) {
            if (isset($in["q"]) && $in["q"] == "0") {
                $query->where("cities.id", Auth::user()->city_id)->get();
            } else if (isset($in["id"])) {
                if ($in["id"] != '') {
                    $query->where("cities.id", $in["id"])->get();
                } else {
                    $query->where("cities.id", -1)->get();
                }
            } else {
                $query->where(DB::raw("cities.description || ' '||departments.description"), "ilike", "%" . $in["q"] . "%")->get();
            }

            $result = $query->get();
        } else {
            $result = array();
        }

        return response()->json(['items' => $result, "pages" => count($result)]);
    }

    public function getDepartment(Request $req) {
        $in = $req->all();

        $query = Department::select("id", "description as text");
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
        $this->in = $req->all();
        $result = array();
        $query = Stakeholder::select("id", DB::raw("coalesce(document,'') ||' - '|| coalesce(business,'') ||' - '|| coalesce(business_name,'') as text"));

        if (isset($this->in["q"]) && $this->in["q"] == "0") {
            $query->where("id", Auth::user()->supplier_id)->get();
        } else if (isset($this->in["id"])) {
            if ($this->in["id"] != '') {
                $result = $query->where("id", $this->in["id"])->get();
            } else {
                $result = array();
            }
        } else {

            if (isset($this->in["q"])) {
                $query->where(function($query) {
                    $query->where("business", "ILIKE", "%" . $this->in["q"] . "%")
                            ->orWhere("business_name", "ILIKE", "%" . $this->in["q"] . "%")
                            ->orWhere("document", "ILIKE", "%" . $this->in["q"] . "%");
                });
                $query->where("type_stakeholder", 1);
//                        ->whereNull("exclude_report");
            }

            $query->where("status_id", 1);
            $result = $query->get();
        }

        return response()->json(['items' => $result, "pages" => count($result)]);
    }

    public function getSupplier(Request $req) {
        $in = $req->all();
        $query = Stakeholder::select("id", DB::raw("coalesce(business,'') || ' - '||coalesce(business_name,'') as text"));
        if (isset($in["q"]) && $in["q"] == "0") {
            $query->where("id", Auth::user()->supplier_id)->get();
        } else if (isset($in["id"])) {
            $query->where("id", $in["id"])->get();
        } else {
            $query
                    ->where("business", "ILIKE", "%" . $in["q"] . "%")
                    ->orWhere("business_name", "ILIKE", "%" . $in["q"] . "%")
                    ->get();
        }

        $result = $query->where("type_stakeholder", 2)
//                ->where("status_id", 1)
                ->get();
//        $result = $query->where("type_stakeholder", 2)->get();

        return response()->json(['items' => $result, "pages" => count($result)]);
    }

    public function getStakeholder(Request $req) {
        $in = $req->all();
        $query = Stakeholder::select("id", "business as text");
        if (isset($in["q"]) && $in["q"] == "0") {
            $query->where("id", Auth::user()->supplier_id)->get();
        } else if (isset($in["id"])) {
            $query->where("id", $in["id"])->get();
        } else {
            $query->where("business", "ILIKE", "%" . $in["q"] . "%")->get();
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

    public function getWarehouseProduct(Request $req) {
        $in = $req->all();
        $query = Warehouses::select("id", "description as text");
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

    public function getNotification(Request $req) {
        $in = $req->all();
        $query = Parameters::select("id", "description as text");
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
        $query->where("group", "notification");
        $result = $query->get();

        return response()->json(['items' => $result, "pages" => count($result)]);
    }

    public function getWarehouse(Request $req) {
        $in = $req->all();
        $query = Warehouses::select("id", "description as text");
        if (isset($in["q"]) && $in["q"] == "0") {
            $query->where("id", Auth::user()->warehouse_id)->get();
        } else if (isset($in["id"])) {
            $query->where("id", $in["id"]);
        } else {
            $query->where("description", "ILIKE", "%" . $in["q"] . "%")->get();
        }
        $result = $query->get();

        return response()->json(['items' => $result, "pages" => count($result)]);
    }

    public function getCategory(Request $req) {
        $in = $req->all();
        $query = Categories::select("id", "description as text");
        if (isset($in["q"]) && $in["q"] == "0") {
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
                $query->where("name", "ilike", "%" . $in["q"] . "%")
//                    ->where("role_id", 4)
                        ->get();
        }
        $result = $query->get();

        return response()->json(['items' => $result, "pages" => count($result)]);
    }

    public function getResponsable(Request $req) {
        $this->input = $req->all();

        $query = Users::select("id", DB::raw("coalesce(name,'') || ' ' || coalesce(last_name,'') || ' ' || email as text"))->whereIn("role_id", [1, 4]);
        if (isset($this->input["q"]) && $this->input["q"] == "0") {
            $city = $query->where("id", Auth::user()->id);
        } else if (isset($this->input["id"]) && $this->input["id"] != '') {
            $query->where("id", $this->input["id"]);
        } else {
            if (isset($this->input["q"])) {
                $query->where(function($query) {
                    $query->where("name", "ilike", "%" . $this->input["q"] . "%")
                            ->Orwhere("last_name", "ilike", "%" . $this->input["q"] . "%")
                            ->Orwhere("email", "ilike", "%" . $this->input["q"] . "%");
                });
            }
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
            if ($in["id"] != '') {
                $query->where("id", $in["id"]);
            }
        } else {
            $query->where("name", "ilike", "%" . $in["q"] . "%")->get();
        }
        $result = $query->get();

        return response()->json(['items' => $result, "pages" => count($result)]);
    }

    public function getProduct(Request $req) {
        $this->input = $req->all();
        $query = Products::select("products.id", DB::raw("products.reference ||' - '|| products.title || ' - ' || stakeholder.business  as text"))
                ->join("stakeholder", "stakeholder.id", "products.supplier_id");

        if (isset($this->input["filter"]) && $this->input["filter"] != '') {
            foreach ($this->input["filter"] as $key => $val) {
                $query->where($key, $val);
            }
        } else if (isset($this->input["id"])) {
            $query->where("products.id", $this->input["id"])->get();
        }

        if (isset($this->input["q"]) && $this->input["q"] != "0") {
            $query->where(function($query) {
                $query->where("products.title", "ILIKE", "%" . $this->input["q"] . "%")
                        ->OrWhere("stakeholder.business", "ILIKE", "%" . $this->input["q"] . "%")
                        ->OrWhere("products.bar_code", "ILIKE", "%" . $this->input["q"] . "%")
                        ->OrWhere(DB::raw("products.reference::text"), "ILIKE", "%" . $this->input["q"] . "%");
            });
        }
        $query->where("products.status_id", 1);
//        $query->whereNull("type_product_id");

        $result = $query->get();

        return response()->json(['items' => $result, "pages" => count($result)]);
    }

    public function getServices(Request $req) {
        $this->input = $req->all();
        $query = Products::select("products.id", DB::raw("products.reference ||' - '|| products.title || ' - ' || stakeholder.business  as text"))
                ->join("stakeholder", "stakeholder.id", "products.supplier_id");

        if (isset($this->input["filter"]) && $this->input["filter"] != '') {
            foreach ($this->input["filter"] as $key => $val) {
                $query->where($key, $val);
            }
        } else if (isset($this->input["id"])) {
            $query->where("id", $this->input["id"])->get();
        }

        if (isset($this->input["q"]) && $this->input["q"] != "0") {
            $query->where(function($query) {
                $query->where("title", "ILIKE", "%" . $this->input["q"] . "%")
                        ->OrWhere("business", "ILIKE", "%" . $this->input["q"] . "%")
                        ->OrWhere("bar_code", "ILIKE", "%" . $this->input["q"] . "%")
                        ->OrWhere(DB::raw("reference::text"), "ILIKE", "%" . $this->input["q"] . "%");
            });
        }

        $query->where("type_product_id", 1);
        $result = $query->get();

        return response()->json(['items' => $result, "pages" => count($result)]);
    }

    public function getBranch(Request $req) {
        $in = $req->all();
        $query = Branch::select("id", "address_invoice as text");
        if (isset($in["q"]) && $in["q"] == "0") {
            $query->where("id", Auth::user()->warehouse_id)->get();
        } else if (isset($in["id"])) {
            if ($in["id"] != '') {
                $query->where("id", $in["id"]);
            }
        } else {
            $query->where("address_invoice", "ilike", "%" . $in["q"] . "%")->get();
        }

        if (isset($in["filter"]) && $in["filter"] != '') {
            foreach ($in["filter"] as $key => $val) {
                $query->where($key, $val);
            }
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
