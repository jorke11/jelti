<?php

namespace App\Http\Controllers\Shopping;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Inventory\Orders;
use App\Models\Inventory\OrdersDetail;
use App\Http\Controllers\Inventory\DepartureController;
use Auth;
use DB;
use Session;
use Illuminate\Support\Facades\Input;

class PaymentController extends Controller {

    public $depObj;

    public function __construct() {
        $this->depObj = new DepartureController();
    }

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

    public function setQuantity(Request $req, $order_id) {
        $in = $req->all();

        $det = OrdersDetail::where("order_id", $order_id)->where("product_id", $in["product_id"])->first();
        $det->quantity = $in["quantity"];
        $det->save();
        return response()->json(["success" => true]);
    }

    /**
     * 
     * array:12 [
      "warehouse_id" => "3"
      "responsible_id" => "14"
      "city_id" => "149"
      "created" => "2017-09-08 11:11"
      "client_id" => "135"
      "destination_id" => "126"
      "address" => "Cra 59B # 84 - 52"
      "phone" => "3205790793"
      "branch_id" => "171"
      "status_id" => 1
      "shipping_cost" => 0
      "type_request" => "web"
      ]
     * */
    public function payment(Request $req) {
        $order = Orders::where("status_id", 1)->where("stakeholder_id", Auth::user()->id)->first();

        $sql = "SELECT p.title product,d.product_id,d.order_id,sum(d.quantity) quantity,sum(d.quantity * d.value) total,p.image
                            FROM orders_detail d
                            JOIN products p ON p.id=d.product_id
                            WHERE order_id=$order->id
                            GROUP BY 1,2,3,product_id,p.image";
        $detail = (array) DB::select($sql);


        $user = \App\Models\Security\Users::find(Auth::user()->id);

        $cli = \App\Models\Administration\Stakeholder::where("document", $user->document)->first();

        $header["warehouse_id"] = 3;
        $header["responsible_id"] = 1;
        $header["city_id"] = 1;
        $header["created"] = date("Y-m-d H:i");
        $header["client_id"] = $cli->id;
        $header["destination_id"] = 1;
        $header["address"] = "adress";
        $header["phone"] = "phone";
        $header["status_id"] = 1;
        $header["shipping_cost"] = 0;
        $header["type_request"] = "ecommerce";

        $this->depObj->processDeparture($header, $detail);
        \Session::flash('success', 'Compra Realizada con exito');

        $order->status_id = 2;
        $order->save();

        return redirect('home');
    }

    public function deleteItem(Request $req, $id) {
        $input = $req->all();
        OrdersDetail::where("order_id", $id)->where("product_id", $input["product_id"])->delete();
        return response()->json($input);
    }

}
