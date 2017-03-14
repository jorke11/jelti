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
use App\Models\Invoicing\Purchases;
use App\Models\Invoicing\PurchasesDetail;
use Session;

class EntryController extends Controller {

    public $total;

    public function __construct() {
        $this->total = 0;
    }

    public function index() {
        $category = Categories::all();
        return view("entry.init", compact("category"));
    }

    public function getConsecutive($id) {
        return response()->json(["response" => 'prueba']);
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
        return response()->json(["response" => $supplier]);
    }

    public function getProducts($id) {
        $resp = \App\Models\Administration\Products::where("supplier_id", $id);
        return response()->json(["response" => $resp]);
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);
//            $user = Auth::User();
//            $input["users_id"] = 1;
            $input["status_id"] = 1;
            $result = Entries::create($input);
            if ($result) {
                Session::flash('save', 'Se ha creado correctamente');
                $resp = Entries::FindOrFail($result["attributes"]["id"]);
                return response()->json(['success' => true, "data" => $resp]);
            } else {
                return response()->json(['success' => false]);
            }
        }
    }

    public function sendPurchase(Request $request) {
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


                if ($total > 860000) {
                    $rete = ($total * 0.025);
                    PurchasesDetail::insert([
                        "entry_id" => $input["id"], "account_id" => 2, "purchase_id" => $id, "value" => ($total * 0.025), "order" => $cont, "description" => "rete",
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

    protected function formatDetail($detail) {
        $this->total = 0;
        foreach ($detail as $i => $val) {
            $detail[$i]->valueFormated = "$ " . number_format($val->value, 2, ',', '.');
            $detail[$i]->total = $detail[$i]->value * $detail[$i]->quantity;
            $detail[$i]->totalFormated = "$ " . number_format($detail[$i]->total, 2, ',', '.');
            $this->total += $detail[$i]->total;
        }


        return $detail;
    }

    public function edit($id) {
        $entry = Entries::FindOrFail($id);
        $detail = DB::table("entries_detail")
                        ->select("entries_detail.id", "expiration_date", "quantity", "value", "products.title as product")
                        ->join("products", "entries_detail.product_id", "products.id")
                        ->where("entry_id", $id)->get();
        $detail = $this->formatDetail($detail);
        $total = "$ " . number_format($this->total, 2, ',', '.');

        return response()->json(["header" => $entry, "detail" => $detail, "total" => $total]);
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
        $result = $entry->fill($input)->save();
        if ($result) {

            $detail = DB::table("entries_detail")
                            ->select("entries_detail.id", "expiration_date", "quantity", "value", "products.title as product")
                            ->join("products", "entries_detail.product_id", "products.id")
                            ->where("entry_id", $input["entry_id"])->get();
            $detail = $this->formatDetail($detail);
            $total = "$ " . number_format($this->total, 2, ',', '.');

            return response()->json(['success' => true, "detail" => $detail, "total" => $total]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function destroy($id) {
        $entry = Entries::FindOrFail($id);
        $result = $entry->delete();
        Session::flash('delete', 'Se ha eliminado correctamente');
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
                $detail = DB::table("entries_detail")
                                ->select("entries_detail.id", "expiration_date", "quantity", "value", "products.title as product")
                                ->join("products", "entries_detail.product_id", "products.id")
                                ->where("entry_id", $input["entry_id"])->get();
                $total = 0;
                $this->formatDetail($detail);
                $total = "$ " . number_format($this->total, 2, ',', '.');
                return response()->json(['success' => true, "detail" => $detail, "total" => $total]);
            } else {
                return response()->json(['success' => false]);
            }
        }
    }

}
