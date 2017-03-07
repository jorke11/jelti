<?php

namespace App\Http\Controllers\Invoicing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Illuminate\Support\Facades\DB;
use App\Models\Administration\Warehouses;
use App\Models\Invoicing\Purchases;
use App\Models\Invoicing\PurchasesDetail;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller {

    public function __construct() {
        $this->middleware("auth");
    }

    public function index() {
        $category = \App\Models\Administration\Categories::all();
        return view("purchase.init", compact("category"));
    }

    public function getConsecutive($id) {
        echo response()->json(["response" => 'prueba']);
    }

    public function getSupplier($id) {
        $stakeholder = \App\Models\Administration\Stakeholder::findOrFail($id);
        return response()->json(["response" => $stakeholder]);
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
            $result = Purchases::create($input);
            if ($result) {
                $resp = Purchases::FindOrFail($result["attributes"]["id"]);
                return response()->json(['success' => 'true', "data" => $resp]);
            } else {
                return response()->json(['success' => 'false']);
            }
        }
    }

    public function edit($id) {
        $entry = Purchases::FindOrFail($id);
        $detail = DB::table("purchases_detail")
                ->select("purchases_detail.id", "products.title as product", "purchases_detail.tax", "purchases_detail.value", "purchases_detail.type_nature", "purchases_detail.quantity", "purchases_detail.description")
                ->leftjoin("products", "purchases_detail.product_id", "products.id")
                ->where("purchase_id", "=", $id)
                ->orderBy('order', 'ASC')
                ->get();

        $debtTotal = 0;
        $creditTotal = 0;
        foreach ($detail as $i => $value) {
            $detail[$i]->valueFormated = "$ " . number_format($value->value, 2, ',', '.');
            if ($detail[$i]->product == '') {
                $detail[$i]->total = $detail[$i]->value;
            } else {
                $detail[$i]->total = $detail[$i]->value * $detail[$i]->quantity;
            }


            $detail[$i]->totalFormated = "$ " . number_format($value->total, 2, ',', '.');

            if ($detail[$i]->type_nature == 1) {
                $detail[$i]->debt = $detail[$i]->total;
                $debtTotal += $detail[$i]->debt;
            } else {
                $detail[$i]->credit = $detail[$i]->total;
                $creditTotal += $detail[$i]->credit;
            }
        }

        return response()->json(["header" => $entry, "detail" => $detail, "totalCredt" => "$ " . number_format($creditTotal, 2, ',', '.'),
            "totalDebt" => "$ " . number_format($debtTotal, 2, ',', '.')]);
    }

    public function getDetail($id) {
        $detail = PurchasesDetail::FindOrFail($id);
        return response()->json($detail);
    }

    public function update(Request $request, $id) {
        $entry = Purchases::FindOrFail($id);
        $input = $request->all();
        $result = $entry->fill($input)->save();
        if ($result) {
            $resp = Purchases::FindOrFail($id);
            return response()->json(['success' => 'true', "data" => $resp]);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

    public function updateDetail(Request $request, $id) {
        $entry = PurchasesDetail::FindOrFail($id);
        $input = $request->all();
        $result = $entry->fill($input)->save();
        if ($result) {
            $resp = DB::table("purchases_detail")
                    ->where("purchase_id", "=", $input["entry_id"])
                    ->get();
            return response()->json(['success' => 'true', "data" => $resp]);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

    public function destroy($id) {
        $entry = Purchases::FindOrFail($id);
        $result = $entry->delete();
        if ($result) {
            return response()->json(['success' => 'true']);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

    public function destroyDetail($id) {
        $entry = PurchasesDetail::FindOrFail($id);
        $result = $entry->delete();
        if ($result) {
            $resp = DB::table("purchases_detail")->where("purchase_id", "=", $entry["purchage_id"])->get();
            return response()->json(['success' => 'true', "data" => $resp]);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

    public function storeDetail(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();

            unset($input["id"]);
//            $user = Auth::User();
//            $input["users_id"] = 1;
            $input["order"] = 1;
            $result = PurchasesDetail::create($input);
            if ($result) {

                $resp = DB::table("purchases_detail")
                        ->where("purchase_id", $input["purchase_id"])
                        ->get();
                return response()->json(['success' => 'true', "data" => $resp]);
            } else {
                return response()->json(['success' => 'false']);
            }
        }
    }

}
