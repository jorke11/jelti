<?php

namespace App\Http\Controllers\Shopping;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Inventory\Orders;
use App\Models\Inventory\OrdersDetail;
use Auth;
use DB;

class PaymentController extends Controller {

    public function index() {
        return view("Ecommerce.payment.init");
    }

    public function getDetail() {
        $order = Orders::where("status_id", 1)->where("stakeholder_id", Auth::user()->id)->first();

        $sql = "SELECT p.title product,d.product_id,d.order_id,sum(d.quantity) quantity,sum(d.quantity * d.value) total,p.image
                            FROM orders_detail d
                            JOIN products p ON p.id=d.product_id
                            WHERE order_id=$order->id
                            GROUP BY 1,2,3,product_id,p.image";
        $detail = DB::select($sql);

        $total = 0;
        foreach ($detail as $i => $value) {
            $detail[$i]->formateTotal = "$ " . number_format($value->total, 2, ",", ".");
            $total += $value->total;
        }
        $total = "$ " . number_format($total, 2, ",", ".");

        return response()->json(["detail" => $detail, "total" => $total]);
    }

    public function payment(Request $req) {
        $order = Orders::where("status_id", 1)->where("stakeholder_id", Auth::user()->id)->first();

        $sql = "SELECT p.title product,d.product_id,d.order_id,sum(d.quantity) quantity,sum(d.quantity * d.value) total,p.image
                            FROM orders_detail d
                            JOIN products p ON p.id=d.product_id
                            WHERE order_id=$order->id
                            GROUP BY 1,2,3,product_id,p.image";
        $detail = DB::select($sql);

        $total = 0;
        foreach ($detail as $i => $value) {
            $detail[$i]->formateTotal = "$ " . number_format($value->total, 2, ",", ".");
            $total += $value->total;
        }
        
        $total = "$ " . number_format($total, 2, ",", ".");
        
        dd($detail);exit;
        
    }

    public function deleteItem(Request $req, $id) {
        $input = $req->all();
        OrdersDetail::where("order_id", $id)->where("product_id", $input["product_id"])->delete();
        return response()->json($input);
    }

}
