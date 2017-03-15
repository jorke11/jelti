<?php

namespace App\Http\Controllers\Invoicing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Invoicing\Sales;
use App\Models\Invoicing\SaleDetail;
use \Illuminate\Support\Facades\DB;
use Session;
use App\Models\Administration\Products;
use App\Models\Administration\Puc;
use Log;

class SaleController extends Controller {

    public $total;
    public $debt;
    public $credit;

    public function __construct() {
        $this->total = 0;
        $this->debt = 0;
        $this->credit = 0;
    }

    public function index() {
        $category = \App\Models\Administration\Categories::all();
        return view("Invoicing.sale.init", compact("category"));
    }

    public function getConsecutive($id) {
        echo response()->json(["response" => 'prueba']);
    }

    public function getQuantity($id) {
        $product = \App\Models\Invoicing\PurchageDetail::where("product_id", $id)->first();
        return response()->json(["response" => $product]);
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);
            $result = Sales::create($input);
            if ($result) {
                $resp = Sales::FindOrFail($result["attributes"]["id"]);
                return response()->json(['success' => 'true', "data" => $resp]);
            } else {
                return response()->json(['success' => 'false']);
            }
        }
    }

    public function edit($id) {
        $entry = Sales::FindOrFail($id);

        $detail = $this->formatDetail($id);

        $debt = "$ " . number_format($this->debt, 2, ",", ".");
        $cred = "$ " . number_format($this->credit, 2, ",", ".");

        return response()->json(["header" => $entry, "detail" => $detail, "debt" => $debt, "credit" => $cred]);
    }

    public function formatDetail($id) {

        $detail = DB::
                        table("sales_detail")
                        ->select("sales_detail.id", "sales_detail.description", "products.title as product", "sales_detail.tax", "sales_detail.quantity", "sales_detail.value", "sales_detail.type_nature")
                        ->where("sale_id", "=", $id)
                        ->leftjoin("products", "sales_detail.product_id", "products.id")
                        ->orderBy("order", "asc")->get();

        $this->debt = 0;
        $this->credit = 0;

        foreach ($detail as $i => $value) {
            $detail[$i]->valueFormated = "$ " . number_format($value->value, 2, ",", ".");
            $value->quantity = ($value->quantity == '') ? '' : $value->quantity;
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

    public function getDetail($id) {
        $detail = SaleDetail::FindOrFail($id);
        return response()->json($detail);
    }

    public function update(Request $request, $id) {
        $entry = Sales::FindOrFail($id);
        $input = $request->all();
        $result = $entry->fill($input)->save();
        if ($result) {
            $resp = Sales::FindOrFail($id);
            Session::flash('save', 'Se ha creado correctamente');
            return response()->json(['success' => 'true', "data" => $resp]);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

    public function updateDetail(Request $request, $id) {
        $entry = SaleDetail::FindOrFail($id);
        $input = $request->all();
        $result = $entry->fill($input)->save();
        if ($result) {
            $resp = DB::table("saledetail")->where("sale_id", "=", $input["sale_id"])->get();
            return response()->json(['success' => 'true', "data" => $resp]);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

    public function destroy($id) {
        $entry = Sales::FindOrFail($id);
        $result = $entry->delete();
        Session::flash('delete', 'Se ha eliminado correctamente');
        if ($result) {
            return response()->json(['success' => 'true']);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

    public function destroyDetail($id) {
        $entry = SaleDetail::FindOrFail($id);
        $result = $entry->delete();
        Session::flash('delete', 'Se ha eliminado correctamente');
        if ($result) {
            $resp = DB::table("saledetail")->where("sale_id", "=", $entry["sale_id"])->get();
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
            $saleDetail = SaleDetail::where("sale_id", $input["sale_id"])->get();

            $pro = Products::FindOrfail($input["product_id"]);
            $account = Puc::where("code", "413501")->first();

            $input["account_id"] = $account["id"];
            $input["tax"] = $pro["tax"];
            $input["order"] = (count($saleDetail) == 0) ? 1 : count($saleDetail) + 1;
            $input["description"] = "product";
            $input["type_nature"] = 1;

            $result = SaleDetail::create($input)->id;

            $account = Puc::where("code", "240801")->first();

            $value = $input["value"];
            $quantity = $input["quantity"];
            $sale_id = $input["sale_id"];
            $input = array();
            $input["account_id"] = $account["id"];
            $input["sale_id"] = $sale_id;
            $input["product_id"] = null;
            $input["parent_id"] = $result;
            $input["tax"] = null;
            $input["order"] = (count($saleDetail) == 0) ? 2 : count($saleDetail) + 2;
            $input["category_id"] = null;
            $input["quantity"] = null;
            $input["value"] = ($pro["tax"] / 100.0) * ($value * $quantity);
            $input["type_nature"] = 1;
            $input["description"] = "tax";
            SaleDetail::create($input);

            $saleDetail = SaleDetail::where("sale_id", $input["sale_id"])->get();

            $total = 0;
            foreach ($saleDetail as $value) {
                if ($value->type_nature == 1)
                    $total += $value->value * (($value->quantity == '') ? 1 : $value->quantity);
            }

            $account = Puc::where("code", "220501")->first();
            $client = SaleDetail::where("sale_id", $input["sale_id"])->where("account_id", $account["id"])->first();

            if (count($client) > 0) {
                $client->value = $total;
                $client->order = count($saleDetail) + 1;
                $client->save();
            } else {
                $input["order"] = count($saleDetail) + 1;
                $input["account_id"] = $account["id"];
                $input["description"] = "Supplier";
                $input["type_nature"] = $account["nature"];
                $input["value"] = $total;
                SaleDetail::create($input);
            }


            if ($result) {

                $detail = $this->formatDetail($input["sale_id"]);

                $debt = "$ " . number_format($this->debt, 2, ",", ".");
                $cred = "$ " . number_format($this->credit, 2, ",", ".");

                return response()->json(['success' => 'true', "detail" => $detail, "debt" => $debt, "credit" => $cred]);
            } else {
                return response()->json(['success' => 'false']);
            }
        }
    }

}
