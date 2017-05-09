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
use App\Models\Administration\Email;
use App\Models\Administration\EmailDetail;
use App\Models\Security\Users;
use App\Models\Administration\Stakeholder;
use App\Models\Administration\Cities;
use Mail;

class PurchaseController extends Controller {

    public $total;
    public $debt;
    public $credit;
    public $mails;
    public $subject;

    public function __construct() {
        $this->total = 0;
        $this->debt = 0;
        $this->credit = 0;
        $this->mails = array();
        $this->subject = "";
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
        $stakeholder->delivery = date('Y-m-d', strtotime('+' . $stakeholder->lead_time . ' days', strtotime(date('Y-m-d'))));
        $products = Products::select("id as product_id", "tax", "description", "title", "cost_sf", "units_supplier", "category_id")
                        ->where("supplier_id", $stakeholder->id)->get();
        return response()->json(["response" => $stakeholder, "products" => $products]);
    }

    public function getProducts($id) {
        $resp = \App\Models\Administration\Products::where("supplier_id", $id);

        return response()->json(["response" => $resp]);
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            $input["header"]["status_id"] = 1;

            unset($input["id"]);
//            $user = Auth::User();

            if (isset($input["detail"])) {

                $input["header"]["consecutive"] = $this->createConsecutive(4);

                $purchase_id = Purchases::create($input["header"])->id;
                $this->updateConsecutive(4);



                foreach ($input["detail"] as $i => $val) {

                    if ($val["quantity"] != 0) {

                        $total = $input["detail"][$i]["quantity"] * $input["detail"][$i]["cost_sf"];
                        $account = Puc::where("code", "143501")->first();

                        $input["detail"][$i]["tax"] = $val["tax"];
                        $input["detail"][$i]["purchase_id"] = $purchase_id;
                        $input["detail"][$i]["account_id"] = $account->id;
                        $input["detail"][$i]["type_nature"] = 1;
                        $input["detail"][$i]["order"] = $i;
                        $input["detail"][$i]["value"] = $val["cost_sf"];
                        $input["detail"][$i]["units_supplier"] = (int) $input["detail"][$i]["units_supplier"];
                        $input["detail"][$i]["description"] = 'product';
                        unset($input["detail"][$i]["cost_sf"]);
                        unset($input["detail"][$i]["title"]);
                        unset($input["detail"][$i]["debt"]);
                        unset($input["detail"][$i]["credit"]);
                        unset($input["detail"][$i]["total"]);

                        $detail_id = PurchasesDetail::create($input["detail"][$i])->id;

                        if ($input["detail"][$i]["tax"] != 0 && $input["detail"][$i]["tax"] != '') {
                            $account = Puc::where("code", "240802")->first();
                            $input["detail"][$i]["account_id"] = $account->id;
                            $input["detail"][$i]["type_nature"] = $account->nature;
                            $input["detail"][$i]["description"] = 'tax';
                            $input["detail"][$i]["value"] = $total * $input["detail"][$i]["tax"];
                            $input["detail"][$i]["parent_id"] = $detail_id;
                            $total += $input["detail"][$i]["value"];
                            unset($input["detail"][$i]["product_id"]);
                            unset($input["detail"][$i]["category_id"]);
                            unset($input["detail"][$i]["quantity"]);
                            unset($input["detail"][$i]["units_supplier"]);
                            unset($input["detail"][$i]["tax"]);
                            PurchasesDetail::create($input["detail"][$i])->id;
                        }

                        $account = Puc::where("code", "220501")->first();

                        $supplier = PurchasesDetail::where("purchase_id", $purchase_id)->where("account_id", $account->id)->first();
                        if (count($supplier) > 0) {

                            $ord = PurchasesDetail::where("purchase_id", $purchase_id)->count();
                            $supplier->order = $ord - 1;
                            $supplier->value = $total;
                            $supplier->save();
                        } else {
                            $input["detail"][$i]["parent_id"] = $detail_id;
                            $input["detail"][$i]["purchase_id"] = $purchase_id;
                            $input["detail"][$i]["account_id"] = $account->id;
                            $input["detail"][$i]["type_nature"] = $account->nature;
                            $input["detail"][$i]["description"] = "supplier";
                            $input["detail"][$i]["value"] = $total;
                            unset($input["detail"][$i]["product_id"]);
                            unset($input["detail"][$i]["category_id"]);
                            unset($input["detail"][$i]["quantity"]);
                            unset($input["detail"][$i]["units_supplier"]);
                            unset($input["detail"][$i]["tax"]);
                            PurchasesDetail::create($input["detail"][$i]);
                        }
                    }
                }

                $detail = $this->formatDetail($purchase_id);
                $debt = "$ " . number_format($this->debt, 2, ",", ".");
                $cred = "$ " . number_format($this->credit, 2, ",", ".");
                $header = Purchases::findOrFail($purchase_id);
                return response()->json(['success' => true, "header" => $header, "detail" => $detail, "totalDebt" => $debt, "totalDebt" => $cred]);
            } else {
                return response()->json(['success' => false, "msg" => "Detail Empty"], 409);
            }
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

                $purchase = Purchases::findOrFail($in["id"]);
                $sup = Stakeholder::find($purchase->supplier_id);

                $input["consecutive"] = $purchase->consecutive;
                $ware = Warehouses::findOrFail($purchase->warehouse_id);
                $input["address"] = $ware->address;
                $input["warehouse"] = $ware->description;

                $user = Users::findOrFail($ware->responsible_id);

                $input["name"] = $user->name;
                $input["last_name"] = $user->last_name;

                $input["detail"] = DB::table("purchases_detail")
                                ->select("purchases_detail.id", "products.title as producto", "purchases_detail.units_supplier", "products.cost_sf", DB::raw("purchases_detail.quantity * purchases_detail.units_supplier as totalunit"), "purchases_detail.quantity", DB::raw("purchases_detail.quantity *  purchases_detail.units_supplier * purchases_detail.value as total"))
                                ->join("products", "products.id", "purchases_detail.product_id")
                                ->where("purchase_id", $purchase->id)->get();

                $email = Email::where("description", "purchases")->first();
                $emDetail = EmailDetail::where("email_id", $email->id)->get();
                if (count($emDetail) > 0) {
                    $this->mails = array();
                    foreach ($emDetail as $value) {
                        $this->mails[] = $value->description;
                    }

                    $cit = Cities::find($ware->city_id);

                    $this->subject = "SuperFuds " . date("d/m") . " " . $sup->business . " " . $cit->description . " " . $pur->consecutive;
                    $input["city"] = $cit->description;

                    Mail::send("Notifications.purchase", $input, function($msj) {
                        $msj->subject($this->subject);
                        $msj->to($this->mails);
                    });
                }


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

    public function formatDetail($id) {
        $detail = DB::table("purchases_detail")
                        ->select("purchases_detail.id", "purchases_detail.description as comment", "products.title as product", DB::raw("coalesce(purchases_detail.tax,0)"), "purchases_detail.quantity", "purchases_detail.value", "purchases_detail.type_nature", "purchases_detail.description")
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
