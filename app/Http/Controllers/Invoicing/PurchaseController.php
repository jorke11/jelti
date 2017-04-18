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
use App\Models\Administration\Products;
use App\Models\Administration\Puc;
use App\models\Administration\Consecutives;
use App\Models\Administration\Parameters;

class PurchaseController extends Controller {

    public $total;
    public $debt;
    public $credit;

    public function __construct() {
        $this->total = 0;
        $this->debt = 0;
        $this->credit = 0;
        $this->middleware("auth");
    }

    public function index() {
        $category = \App\Models\Administration\Categories::all();
        $status = Parameters::where("group", "entry")->get();

        return view("Invoicing.purchase.init", compact("category", "status"));
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

    public function getConsecutive($id) {
        return response()->json(["response" => $this->createConsecutive(4)]);
    }

    public function updateConsecutive($id) {
        $con = Consecutives::where("type_form", $id)->first();
        $con->current = (($con->current == null) ? 1 : $con->current) + 1;
        $con->save();
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
            $input["status_id"] = 1;
            $input["consecutive"] = $this->createConsecutive(4);
            $result = Purchases::create($input)->id;
            if ($result) {
                $resp = Purchases::FindOrFail($result);
                $this->updateConsecutive(4);
                return response()->json(['success' => true, "data" => $resp]);
            } else {
                return response()->json(['success' => false]);
            }
        }
    }

    public function sendPurchase(Request $req) {
        $in = $req->all();
        $pur = Purchases::findOrFail($in["id"]);

        $val = PurchasesDetail::where("purchase_id", $pur["id"])->count();

        if ($val > 0) {
            if ($pur["status_id"] == 2) {
                return response()->json(["success" => false, "msg" => "Already sended"], 409);
            } else {
                $pur->status_id = 2;
                $pur->save();
                $pur = Purchases::findOrFail($in["id"]);
                return response()->json(["success" => true, "header" => $pur]);
            }
        } else {
            return response()->json(["success" => false, "msg" => "Detail empty"], 409);
        }
    }

    public function edit($id) {
        $entry = Purchases::FindOrFail($id);

        $detail = DB::table("purchases_detail")
                ->select("purchases_detail.id", "purchases_detail.description as comment", "products.title as product", "purchases_detail.tax", "purchases_detail.value", "purchases_detail.type_nature", "purchases_detail.quantity", "purchases_detail.description")
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
            return response()->json(['success' => true, "data" => $resp]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function updateDetail(Request $request, $id) {
        $entry = PurchasesDetail::FindOrFail($id);
        $input = $request->all();

        $pro = Products::findOrFail($input["product_id"]);


        $input["value"] = $request["quantity"] * $request["value"];
        $result = $entry->fill($input)->save();

        $tax = PurchasesDetail::where("parent_id", $input["purchase_id"])->where("type_nature", 1)->first();
        $tax->value = ($pro["tax"] / 100.0) * $input["value"];
        $tax->save();


        $detail = PurchasesDetail::where("purchase_id", $input["purchase_id"])->get();
        $total = 0;
        foreach ($detail as $value) {
            $total += ($value->value * $value->quantity);
        }

        $client = PurchasesDetail::where("parent_id", $input["purchase_id"])->where("type_nature", 2)->first();
        $client->value = $total;
        $client->save();

        if ($result) {
            $detail = $this->formatDetail($input["purchase_id"]);
            $debt = "$ " . number_format($this->debt, 2, ",", ".");
            $cred = "$ " . number_format($this->credit, 2, ",", ".");
            return response()->json(['success' => 'true', "detail" => $detail, "totalDebt" => $debt, "totalDebt" => $cred]);


            return response()->json(['success' => true, "data" => $resp]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function destroy($id) {
        $entry = Purchases::FindOrFail($id);
        $result = $entry->delete();
        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function destroyDetail($id) {
        $entry = PurchasesDetail::FindOrFail($id);

        dd($entry);
        exit;

        $result = $entry->delete();
        if ($result) {
            $resp = DB::table("purchases_detail")->where("purchase_id", "=", $entry["purchage_id"])->get();
            return response()->json(['success' => true, "data" => $resp]);
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

            $saleDetail = PurchasesDetail::where("purchase_id", $input["purchase_id"])->get();

            $pro = Products::findOrFail($input["product_id"]);
            $account = Puc::where("code", "143501")->first();
            $input["account_id"] = $account["id"];
            $input["type_nature"] = 1;
            $input["order"] = (count($saleDetail) == 0) ? 1 : count($saleDetail) + 1;
            $input["description"] = "product";

            $result = PurchasesDetail::create($input)->id;

            $account = Puc::where("code", "240802")->first();
            $value = $input["value"];
            $purchase_id = $input["purchase_id"];
            $input = array();
            $input["account_id"] = $account["id"];
            $input["purchase_id"] = $purchase_id;
            $input["product_id"] = null;
            $input["parent_id"] = $result;
            $input["tax"] = null;
            $input["order"] = (count($saleDetail) == 0) ? 2 : count($saleDetail) + 2;
            $input["category_id"] = null;
            $input["quantity"] = null;
            $input["value"] = ($pro["tax"] / 100.0) * $value;
            $input["type_nature"] = 1;
            $input["description"] = "tax";

            PurchasesDetail::create($input);

            $saleDetail = PurchasesDetail::where("purchase_id", $input["purchase_id"])->get();

            $total = 0;
            foreach ($saleDetail as $value) {
                $total += $value->value;
            }

            $account = Puc::where("code", "220501")->first();

            $client = PurchasesDetail::where("purchase_id", $input["purchase_id"])->where("account_id", $account["id"])->first();

            if (count($client) > 0) {
                $client->value = $total;
                $client->order = count($saleDetail) + 1;
                $client->save();
            } else {
                $input["order"] = count($saleDetail) + 1;
                $input["account_id"] = $account["id"];
                $input["description"] = "Client";
                $input["type_nature"] = $account["nature"];
                $input["value"] = $total;

                PurchasesDetail::create($input);
            }

            if ($result) {
                $detail = $this->formatDetail($input["purchase_id"]);
                $debt = "$ " . number_format($this->debt, 2, ",", ".");
                $cred = "$ " . number_format($this->credit, 2, ",", ".");
                return response()->json(['success' => true, "detail" => $detail, "totalDebt" => $debt, "totalDebt" => $cred]);
            } else {
                return response()->json(['success' => false]);
            }
        }
    }

    public function formatDetail($id) {
        $detail = DB::table("purchases_detail")
                        ->select("purchases_detail.id", "purchases_detail.description as comment", "products.title as product", "purchases_detail.tax", "purchases_detail.quantity", "purchases_detail.value", "purchases_detail.type_nature", "purchases_detail.description")
                        ->where("purchase_id", "=", $id)
                        ->leftjoin("products", "purchases_detail.product_id", "products.id")
                        ->orderBy("order", "asc")->get();

        foreach ($detail as $i => $value) {
            $detail[$i]->valueFormated = "$ " . number_format($value->value, 2, ",", ".");
            $value->quantity = ($value->quantity == '') ? 1 : $value->quantity;
            $detail[$i]->total = $value->value * (($value->quantity == '') ? 1 : $value->quantity);
            $detail[$i]->totalFormated = "$ " . number_format($detail[$i]->total, 2, ",", ".");
            if ($detail[$i]->type_nature == 1) {
                $this->debt += $detail[$i]->total;
            } else {
                $this->credit += $detail[$i]->total;
            }
        }
        return $detail;
    }

}
