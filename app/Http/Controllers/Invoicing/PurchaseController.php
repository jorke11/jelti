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
use App\Models\Inventory\Entries;
use App\Models\Inventory\EntriesDetail;
use Mail;

class PurchaseController extends Controller {

    public $subtotal;
    public $total;
    public $tax5;
    public $tax19;
    public $exempt;
    public $mails;
    public $subject;

    public function __construct() {
        $this->exempt = 0;
        $this->total = 0;
        $this->subtotal = 0;
        $this->tax5 = 0;
        $this->tax19 = 0;
        $this->mails = array();
        $this->subject = "";
        $this->middleware("auth");
    }

    public function index() {
        $category = \App\Models\Administration\Categories::all();
        $status = Parameters::where("group", "entry")->get();
        return view("Invoicing.purchase.init", compact("category", "status"));
    }

    public function getSupplier($id) {
        $stakeholder = \App\Models\Administration\Stakeholder::findOrFail($id);
        $stakeholder->delivery = date('Y-m-d', strtotime('+' . $stakeholder->lead_time . ' days', strtotime(date('Y-m-d'))));

        $products = Products::select("id as product_id", "tax", "title", "cost_sf", "units_supplier", "category_id")
                        ->where("supplier_id", $stakeholder->id)->where("status_id", 1)->orderBy("title", "asc")->get();
        return response()->json(["response" => $stakeholder, "products" => $products]);
    }

    public function getProducts($id) {
        $resp = \App\Models\Administration\Products::where("supplier_id", $id);

        return response()->json(["response" => $resp]);
    }

    public function reverse($id) {
        try {
            DB::beginTransaction();
            $row = Purchases::find($id);

            $ayer = date("Y-m-d", strtotime("-10 day", strtotime(date("Y-m-d"))));


            if (strtotime($ayer) <= strtotime(date("Y-m-d", strtotime($row->dispatched))) || $row->status_id == 2 || Auth::user()->id == 2) {
                $sal = Entries::where("purchase_id", $id)->first();
                if ($sal != null) {
                    $detail = EntriesDetail::where("entry_id", $sal->id)->get();

                    foreach ($detail as $value) {
                        $det = EntriesDetail::find($value->id);
                        $det->delete();
                    }
                    $sal->delete();
                }

                $row->status_id = 1;
                $row->save();
                DB::commit();
                $dep = Purchases::find($id);


                return response()->json(["success" => true, "header" => $dep]);
            } else {
                return response()->json(['success' => false, "msg" => "Fecha de emisión supera el tiempo permitido, 1 día"], 409);
            }
        } catch (Exception $exp) {
            DB::rollback();
            return response()->json(["success" => false], 409);
        }
    }

    public function getAllDetail($purchase_id) {
        $departure = Purchases::find($purchase_id);
        $detail = $this->formatDetail($purchase_id);

        return response()->json(["detail" => $detail,
                    "total" => "$ " . number_format($this->total - $departure->discount, 0, ",", "."),
//                    "total_real" => "$ " . number_format($this->total_real - $departure->discount, 0, ",", "."),
                    "subtotal" => "$ " . number_format($this->subtotal, 0, ",", "."),
//                    "subtotal_real" => "$ " . number_format($this->subtotal_real, 0, ",", "."),
                    "tax5" => "$ " . number_format($this->tax5, 0, ",", "."),
//                    "tax5_real" => "$ " . number_format($this->tax5_real, 0, ",", "."),
                    "tax19" => "$ " . number_format($this->tax19, 0, ",", "."),
//                    "tax19_real" => "$ " . number_format($this->tax19_real, 0, ",", "."),
//                    "exento" => "$ " . number_format($this->exento, 0, ",", "."),
//                    "exento_real" => "$ " . number_format($this->exento_real, 0, ",", "."),
                    "discount" => "$ " . number_format($departure->discount, 0, ",", "."),
                    "shipping_cost" => "$ " . number_format($departure->shipping_cost, 0, ",", ".")
        ]);
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            $input["header"]["status_id"] = 1;

            unset($input["id"]);
//            $user = Auth::User();
//            echo "<ore>";print_r($input);exit;

            if (isset($input["detail"])) {

                $purchase_id = Purchases::create($input["header"])->id;

                foreach ($input["detail"] as $i => $val) {

                    if ($val["quantity"] != 0) {
                        $total = $input["detail"][$i]["quantity"] * $input["detail"][$i]["cost_sf"];
                        $account = Puc::where("code", "143501")->first();
                        $input["detail"][$i]["tax"] = $val["tax"];
                        $input["detail"][$i]["purchase_id"] = $purchase_id;
                        $input["detail"][$i]["account_id"] = $account->id;
                        $input["detail"][$i]["type_nature"] = 1;
                        $input["detail"][$i]["status_id"] = 1;
                        $input["detail"][$i]["real_quantity"] = 0;
                        $input["detail"][$i]["order"] = $i;
                        $input["detail"][$i]["value"] = $val["cost_sf"];
                        $input["detail"][$i]["units_supplier"] = (int) $input["detail"][$i]["units_supplier"];
//                        $input["detail"][$i]["real_quantity"] = 0;
                        unset($input["detail"][$i]["cost_sf"]);
                        unset($input["detail"][$i]["title"]);
                        unset($input["detail"][$i]["debt"]);
                        unset($input["detail"][$i]["credit"]);
                        unset($input["detail"][$i]["total"]);

                        $detail_id = PurchasesDetail::create($input["detail"][$i])->id;

//                        for ($j = 0; $j < $val["quantity"]; $j++) {
//                            $input["detail"][$i]["quantity"] = 1;
//                            $detail_id = PurchasesDetail::create($input["detail"][$i])->id;
//                        }
                    }
                }

                $detail = $this->formatDetail($purchase_id);
                $header = Purchases::findOrFail($purchase_id);
                $this->subtotal = "$ " . number_format($this->subtotal, 0, ',', '.');
                $this->total = "$ " . number_format($this->total, 0, ',', '.');
                $this->tax5 = "$ " . number_format($this->tax5, 0, ',', '.');
                $this->tax19 = "$ " . number_format($this->tax19, 0, ',', '.');

                return response()->json(['success' => true, "header" => $header, "detail" => $detail, "total" => $this->total,
                            "subtotal" => $this->subtotal, "tax5" => $this->tax5, "tax19" => $this->tax19]);
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
                try {
                    DB::beginTransaction();
                    $this->mails = array();
                    $pur->status_id = 2;
                    $pur->save();

                    $det = PurchasesDetail::where("purchase_id", $in["id"])->get();

                    $purchase = Purchases::findOrFail($in["id"]);

                    $sup = Stakeholder::find($purchase->supplier_id);

                    $ware = Warehouses::findOrFail($purchase->warehouse_id);

                    $input["id"] = $purchase->id;
                    $input["address"] = $ware->address;
                    $input["warehouse"] = $ware->description;

                    $user = Users::findOrFail($ware->responsible_id);

                    $input["name"] = $user->name;
                    $input["last_name"] = $user->last_name;
                    $input["phone"] = $user->phone;
                    $input["environment"] = env("APP_ENV");
                    $input["created_at"] = $purchase->created_at;
                    $input["description"] = $purchase->description;


                    $input["detail"] = $this->formatDetail($purchase->id);
                    $input["tax5"] = $this->tax5;
                    $input["tax19"] = $this->tax19;
                    $input["subtotal"] = $this->subtotal;
                    $input["total"] = $this->total;

                    $email = Email::where("description", "purchases")->first();
                    $emDetail = EmailDetail::where("email_id", $email->id)->get();

                    if (count($emDetail) > 0) {
                        $this->mails[] = $user->email;
                        foreach ($emDetail as $value) {
                            $this->mails[] = $value->description;
                        }

                        $cit = Cities::find($ware->city_id);

                        $this->subject = "SuperFuds " . date("d/m") . " " . $sup->business . " " . $cit->description . " " . $pur->id;
                        $input["city"] = $cit->description;


                        if ($input["environment"] == 'local') {
                            $this->mails = Auth::User()->email;
                        }

                        Mail::send("Notifications.purchase", $input, function($msj) {
                            $msj->subject($this->subject);
                            $msj->to($this->mails);
                        });
                    }

                    DB::commit();

                    $detail = $this->formatDetail($pur->id);
                    $header = Purchases::findOrFail($pur->id);
                    $this->subtotal = "$ " . number_format($this->subtotal, 0, ',', '.');
                    $this->total = "$ " . number_format($this->total, 0, ',', '.');
                    $this->tax5 = "$ " . number_format($this->tax5, 0, ',', '.');
                    $this->tax19 = "$ " . number_format($this->tax19, 0, ',', '.');

                    return response()->json(['success' => true, "header" => $header, "detail" => $detail, "total" => $this->total,
                                "subtotal" => $this->subtotal, "tax5" => $this->tax5, "tax19" => $this->tax19]);
                } catch (Exception $exp) {
                    DB::rollback();
                    return response()->json(['success' => false, "msg" => "Wrong"], 409);
                }
            }
        } else {
            return response()->json(["success" => false, "msg" => "Detail empty"], 409);
        }
    }

    public function testNotification() {
        $data["id"] = "res";
        $data["city"] = "res";
        $data["detail"] = $this->formatDetail(207);
//        dd($data);
        $data["warehouse"] = "";
        $data["address"] = "";
        $data["name"] = "";
        $data["last_name"] = "";
        $data["phone"] = "";
        $data["flete"] = 10;
        $data["tax5"] = 10;
        $data["tax19"] = 10;
        $data["discount"] = 10;
        $data["subtotal"] = 10;
        $data["total"] = 10;
        $data["environment"] = "local";
        $data["created_at"] = "local";
        $data["description"] = "description";
        return view("Notifications.purchase", $data);
    }

    public function edit($id) {
        $entry = Purchases::FindOrFail($id);
        $detail = $this->formatDetail($id);

        $this->total = "$ " . number_format($this->total, 0, ',', '.');
        $this->subtotal = "$ " . number_format($this->subtotal, 0, ',', '.');
        return response()->json(["header" => $entry, "detail" => $detail, "total" => $this->total, "subtotal" => $this->subtotal]);
    }

    public function getDetail($id) {
        $detail = PurchasesDetail::find($id);
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

        $row = PurchasesDetail::Find($id);
        $input = $request->all();
        $purchase_id = $input["purchase_id"];

        unset($input["purchase_id"]);
        $input["real_quantity"] = 0;

        if (isset($input["detail"])) {
            $det = [];
            foreach ($input["detail"] as $value) {
                
                if (isset($value["quantity"]) && $value["quantity"] > 0) {
                    $det[] = $value;
                    $input["real_quantity"] += (int) $value["quantity"];
                }
            }
            $input["detail"] = json_encode($det);
        } else {
            $input["detail"] = null;
        }

        $input["status_id"] = 2;

        $result = $row->fill($input)->save();

        if ($result) {
            $detail = $this->formatDetail($purchase_id);
            $this->subtotal = "$ " . number_format($this->subtotal, 0, ',', '.');
            $this->total = "$ " . number_format($this->total, 0, ',', '.');
            $this->tax5 = "$ " . number_format($this->tax5, 0, ',', '.');
            $this->tax19 = "$ " . number_format($this->tax19, 0, ',', '.');

            return response()->json(['success' => true, "detail" => $detail, "total" => $this->total,
                        "subtotal" => $this->subtotal, "tax5" => $this->tax5, "tax19" => $this->tax19]);
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

        $result = $entry->delete();
        if ($result) {
            $resp = DB::table("purchases_detail")->where("purchase_id", "=", $entry["purchage_id"])->get();
            return response()->json(['success' => true, "data" => $resp]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function formatDetail($id) {
        $sql = "
            select 
            d.id,
                p.id as product_id,
                p.title as product,
                d.units_supplier,
                d.tax,d.value,
                (d.quantity * d.units_supplier) quantity_total,d.purchase_id, (d.value * d.units_supplier * d.quantity) as total, d.quantity,
                p.bar_code as ean,
                (d.value * d.units_supplier * d.real_quantity) as total_real,
                d.status_id,
                d.real_quantity,
                d.detail
            from purchases_detail d
            JOIN products p On p.id=d.product_id 
            where d.purchase_id=" . $id . "
                ORDER by id
                ";


        $detail = DB::select($sql);

        $this->subtotal = 0;
        $this->total = 0;
        foreach ($detail as $i => $value) {
            $this->subtotal += $detail[$i]->total;
            $this->total += $value->total + ($detail[$i]->total * $value->tax);
            $detail[$i]->valueFormated = "$ " . number_format($value->value, 2, ",", ".");
            $detail[$i]->costFormated = "$ " . number_format($detail[$i]->value, 2, ",", ".");
            $detail[$i]->totalFormated = "$ " . number_format($value->total, 2, ",", ".");

            if ($value->tax == 0) {
                $this->exempt += $value->total;
            }
            if ($value->tax == 0.05) {
                $this->tax5 += $detail[$i]->total * $value->tax;
            }
            if ($value->tax == 0.19) {
                $this->tax19 += $detail[$i]->total * $value->tax;
            }
        }

        return $detail;
    }

}
