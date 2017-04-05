<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Administration\Warehouses;
use App\Models\Administration\Products;
use App\Models\Inventory\Entries;
use App\Models\Inventory\EntriesDetail;
use App\Models\Administration\Categories;
use App\Models\Administration\Parameters;
use App\models\Administration\Consecutives;
use App\Models\Invoicing\Purchases;
use App\Models\Invoicing\PurchasesDetail;
use Session;

class EntryController extends Controller {

    public $total;
    public $total_real;

    public function __construct() {
        $this->total = 0;
        $this->total_real = 0;
        $this->middleware("auth");
    }

    public function index() {
        $category = Categories::all();
        $status = Parameters::where("group", "entry")->get();
        return view("Inventory.entry.init", compact("category", "status"));
    }

    public function createConsecutive($id) {
        $con = Consecutives::where("type_form", $id)->first();

        $con->current = ($con->current == null) ? 1 : $con->current;
        $res = "";
        for ($i = strlen($con->pronoun); $i <= ($con->large - strlen($con->current)); $i++) {
            $res .= '0';
        }
        return $con->pronoun . $res . $con->current;
    }

    public function updateConsecutive($id) {
        $con = Consecutives::where("type_form", $id)->first();
        $con->current = (($con->current == null) ? 1 : $con->current) + 1;
        $con->save();
    }

    public function getConsecutive($id) {
        return response()->json(["response" => $this->createConsecutive(2)]);
    }

    public function getDetailProduct($id) {
        $category = DB::table("products")
                ->select("products.id", "products.title", "products.category_id", "categories.description as caterory", "products.price_sf")
                ->join("categories", "categories.id", "=", "products.category_id")
                ->where("products.id", $id)
                ->first();

        return response()->json(["response" => $category]);
    }

    public function getSupplier($id) {
        $supplier = \App\Models\Administration\Stakeholder::findOrFail($id);
        $purc = Purchases::where("supplier_id", $supplier["id"])->where("status_id", 2)->get();
        return response()->json(["response" => $supplier, "purchases" => $purc]);
    }

    public function getProducts($id) {
        $resp = \App\Models\Administration\Products::where("supplier_id", $id);
        return response()->json(["response" => $resp]);
    }

    public function getPurchase($id) {
        $detail = DB::table("purchases_detail")
                        ->select("purchases_detail.id", "purchases_detail.quantity", "purchases_detail.value", "products.title as product")
                        ->join("products", "purchases_detail.product_id", "products.id")
                        ->where("purchase_id", $id)->whereNotNull('product_id')->get();

        $this->total = 0;
        $this->total_real = 0;
        foreach ($detail as $i => $val) {
            $detail[$i]->valueFormated = "$ " . number_format($val->value, 2, ',', '.');
            $detail[$i]->total = $detail[$i]->value * $detail[$i]->quantity;
            $detail[$i]->totalFormated = "$ " . number_format($detail[$i]->total, 2, ',', '.');
            $detail[$i]->real_quantity = (isset($detail[$i]->real_quantity)) ? $detail[$i]->real_quantity : $detail[$i]->quantity;
            $detail[$i]->total_real = $detail[$i]->value * $detail[$i]->real_quantity;
            $detail[$i]->totalFormated_real = "$ " . number_format($detail[$i]->total_real, 2, ',', '.');
            $this->total += $detail[$i]->total;
            $this->total_real += $detail[$i]->total_real;
        }

        $total = "$ " . number_format($this->total, 2, ',', '.');
        $total_real = "$ " . number_format($this->total_real, 2, ',', '.');

        return response()->json(["success" => true, "detail" => $detail, "total" => $total, "total_real" => $total_real]);
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);
//            $user = Auth::User();
//            $input["users_id"] = 1;
            $input["status_id"] = 1;
            $input["consecutive"] = $this->createConsecutive(2);
            $result = Entries::create($input)->id;

            if ($result) {
                $this->updateConsecutive(2);
                $resp = Entries::FindOrFail($result);

                $purc = Purchases::findOrFail($input["purchase_id"]);
                $purc->status_id = 3;
                $purc->save();

                $detail = PurchasesDetail::where("purchase_id", $input["purchase_id"])->whereNotNull('product_id')->get();

                foreach ($detail as $value) {
                    EntriesDetail::insert([
                        "entry_id" => $result, "product_id" => $value->product_id, "quantity" => $value->quantity, "value" => $value->value, "status_id" => 1
                    ]);
                }


                $detailEntry = $this->formatDetail($result);

                $total = "$ " . number_format($this->total, 2, ',', '.');
                $total_real = "$ " . number_format($this->total_real, 2, ',', '.');

                return response()->json(['success' => true, "header" => $resp, "detail" => $detailEntry, "total" => $total, "total_real" => $total_real]);
            } else {
                return response()->json(['success' => false]);
            }
        }
    }

    public function sendPurchase(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            $entry = Entries::findOrFail($input["id"]);

            $exist = Purchases::findOrFail($entry["purchase_id"]);

            $val = EntriesDetail::where("entry_id", $entry["id"])->where("status_id", 1)->count();

            if ($val == 0) {
                if ($entry["status_id"] != 2) {
                    $entry->status_id = 2;
                    $entry->save();
                    $exist->status_id = 4;
                    $exist->save();
                    return response()->json(["success" => true, "header" => $entry]);
                } else {
                    return response()->json(["success" => false, "msg" => "Entry is already generate"], 404);
                }
            } else {
                return response()->json(["success" => false, "msg" => "All Entry detail must be checked"], 409);
            }
        } else {
            return response()->json(["success" => false, "msg" => "Wrong"]);
        }
    }

    public function sendPurchase2(Request $request) {
        if ($request->ajax()) {

            $input = $request->all();
            $purchase = new \App\Models\Invoicing\Purchases();
            $entry = Entries::findOrFail($input["id"]);

            $exist = Purchases::where("entry_id", $entry["id"])->first();

            if (count($exist) == 0) {



                $id = DB::table("purchases")->insertGetId(
                        ["entry_id" => $entry["id"], "warehouse_id" => $entry["warehouse_id"], "responsible_id" => $entry["responsible_id"],
                            "supplier_id" => $entry["supplier_id"], "city_id" => $entry["city_id"], "description" => $entry["description"],
                            "invoice" => $entry["invoice"], "status_id" => $entry["status_id"], "created" => $entry["created"]
                        ]
                );

                $detail = \App\Models\Inventory\EntriesDetail::where("entry_id", $input["id"])->get();
                $total = 0;
                $cont = 0;
                $credit = 0;
                $tax = 0;
                $totalPar = 0;
                foreach ($detail as $value) {
                    $pro = Products::findOrFail($value->product_id);
                    $totalPar = $value->quantity * $value->value;
                    $total += $totalPar;
                    $idDetail = PurchasesDetail::insertGetId([
                                'purchase_id' => $id, "entry_id" => $input["id"], "product_id" => $value->product_id,
                                "category_id" => $value->category_id, "quantity" => $value->quantity,
                                "expiration_date" => $value->expiration_date, "value" => $value->value, "tax" => $pro["tax"],
                                "lot" => $value->lot, "account_id" => 1, "order" => $cont, "description" => "product", "type_nature" => 1
                    ]);

                    $credit += (double) $totalPar;
                    if ($pro["tax"] != '' && $pro["tax"] > 0) {
                        $cont++;
                        $tax = (( $value->value * $value->quantity) * ($pro["tax"] / 100.0));
                        PurchasesDetail::insert([
                            "entry_id" => $input["id"], "account_id" => 1, "purchase_id" => $id, "value" => $tax,
                            "order" => $cont, "description" => "iva", "type_nature" => 1, "parent_id" => $idDetail
                        ]);
                    }
                    $credit += (double) $tax;
                    $cont++;
                }

                $rete = Parameters::where("group", "tax")->where("code", 1)->first();
                $iva = Parameters::where("group", "tax")->where("code", 2)->first();

                if ($total > $iva["value"]) {
                    $rete = ($total * $rete["value"]);
                    PurchasesDetail::insert([
                        "entry_id" => $input["id"], "account_id" => 2, "purchase_id" => $id, "value" => ($total * $rete["value"]), "order" => $cont, "description" => "rete",
                        "type_nature" => 2
                    ]);
                    $credit -= $rete;
                    $cont++;
                }

                PurchasesDetail::insert([
                    "entry_id" => $input["id"], "account_id" => 2, "purchase_id" => $id, "value" => $credit, "order" => $cont, "description" => "proveedores",
                    "type_nature" => 2
                ]);

                $credit = 0;
                $purchase = $entry;

                $entry->status_id = 2;
                $entry->save();

                $entry = Entries::findOrFail($entry["id"]);

                return response()->json(["success" => true, "header" => $entry]);
            } else {
                return response()->json(["success" => false, "msg" => "Entry is already generate"]);
            }
        } else {
            return response()->json(["success" => false, "msg" => "Wrong"]);
        }
    }

    protected function formatDetail($id) {

        $detail = DB::table("entries_detail")
                        ->select("entries_detail.id", "entries_detail.status_id", "entries_detail.real_quantity", "expiration_date", "quantity", "entries_detail.value", "products.title as product", "entries_detail.description", "parameters.description as status")
                        ->join("products", "entries_detail.product_id", "products.id")
                        ->join("parameters", "entries_detail.status_id", DB::raw("parameters.id and parameters.group='entry'"))
                        ->where("entry_id", $id)->get();
        $this->total = 0;
        $this->total_real = 0;
        foreach ($detail as $i => $val) {
            $detail[$i]->valueFormated = "$ " . number_format($val->value, 2, ',', '.');
            $detail[$i]->total = $detail[$i]->value * $detail[$i]->quantity;
            $detail[$i]->totalFormated = "$ " . number_format($detail[$i]->total, 2, ',', '.');

            $detail[$i]->total_real = $detail[$i]->value * $detail[$i]->real_quantity;
            $detail[$i]->totalFormated_real = "$ " . number_format($detail[$i]->total_real, 2, ',', '.');
            $this->total += $detail[$i]->total;
            $this->total_real += $detail[$i]->total_real;
        }

        return $detail;
    }

    public function edit($id) {
        $entry = Entries::FindOrFail($id);
        $detail = $this->formatDetail($id);
        $cons = Purchases::findOrfail($entry["purchase_id"]);

        $total = "$ " . number_format($this->total, 2, ',', '.');
        $total_real = "$ " . number_format($this->total_real, 2, ',', '.');

        return response()->json(["header" => $entry, "detail" => $detail, "total" => $total, "total_real" => $total_real, "consecutive" => $cons]);
    }

    public function getDetail($id) {
        $detail = EntriesDetail::FindOrFail($id);
        return response()->json($detail);
    }

    public function update(Request $request, $id) {
        $entry = Entries::FindOrFail($id);
        $input = $request->all();
        $result = $entry->fill($input)->save();
        if ($result) {
            $resp = Entries::FindOrFail($id);
            return response()->json(['success' => true, "data" => $resp]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function updateDetail(Request $request, $id) {
        $entry = EntriesDetail::FindOrFail($id);
        $input = $request->all();

        $input["status_id"] = 3;

        if ($input["real_quantity"] <= $input["quantity"]) {
            $result = $entry->fill($input)->save();

            if ($result) {
                $detail = $this->formatDetail($input["entry_id"]);
                $total = "$ " . number_format($this->total, 2, ',', '.');
                $real = "$ " . number_format($this->total_real, 2, ',', '.');

                return response()->json(['success' => true, "detail" => $detail, "total" => $total, "total_real" => $real]);
            } else {
                return response()->json(['success' => false]);
            }
        } else {
            return response()->json(['success' => false, "msg" => "Can not exceeded the amount " . $input["quantity"]], 409);
        }
    }

    public function destroy($id) {
        $entry = Entries::FindOrFail($id);
        $result = $entry->delete();
        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function destroyDetail($id) {
        $entry = EntriesDetail::FindOrFail($id);
        $entry_id = $entry["entry_id"];
        $result = $entry->delete();
        if ($result) {
            $detail = DB::table("entries_detail")
                            ->select("entries_detail.id", "expiration_date", "quantity", "value", "products.title as product")
                            ->join("products", "entries_detail.product_id", "products.id")
                            ->where("entry_id", $entry_id)->get();
            $detail = $this->formatDetail($detail);
            $total = "$ " . number_format($this->total, 2, ',', '.');

            return response()->json(['success' => true, "detail" => $detail, "total" => $total]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function storeDetail(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();

            unset($input["id"]);
//            $user = Auth::User();
//            $input["users_id"] = 1;
            $result = EntriesDetail::create($input);

            if ($result) {
                $total = 0;
                $detail = $this->formatDetail($input["entry_id"]);
                $total = "$ " . number_format($this->total, 2, ',', '.');
                return response()->json(['success' => true, "detail" => $detail, "total" => $total]);
            } else {
                return response()->json(['success' => false]);
            }
        }
    }

}
