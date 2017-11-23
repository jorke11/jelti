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
use App\Models\Administration\Stakeholder;

class PaymentController extends Controller {

    public $depObj;
    public $merchantId;
    public $accountId;
    public $description;
    public $referenceCode;
    public $buyerEmail;
    public $currency;
    public $ApiKey;
    public $ApiLogin;
    public $amount;

    public function __construct() {
        $this->middleware("auth");
        $this->depObj = new DepartureController();
        $this->merchantId = "508029";
        $this->accountId = "512321";
        $this->description = "Ventas en linea";
        $this->referenceCode = "invoice001";
        $this->buyerEmail = "jpinedom@hotmail.com";
        $this->currency = "COP";
        $this->ApiKey = "4Vj8eK4rloUd272L48hsrarnUA";
        $this->ApiLogin = "pRRXKOl8ikMmt9u";
        $this->amount = 0;
    }

    public function index() {
        $client = Stakeholder::where("document", Auth::user()->document)->first();
        return view("Ecommerce.payment.init", compact("client"));
    }

    public function generatekey() {
        $key = md5($this->ApiKey . "~" . $this->merchantId . "~" . $this->referenceCode . "~" . $this->currency);
        return response()->json(["key" => $key]);
    }

    public function getDetail() {
        $detail = $this->getDetailData();
        if ($detail != null) {
            $total = "$ " . number_format($this->amount, 0, ",", ".");
            return response()->json(["detail" => $detail, "total" => $total]);
        } else {
            return response()->json(["success" => false, "total" => 0], 509);
        }
    }

    public function getDetailData() {
        $detail = null;
        if (Auth::user() != null) {
            $order = Orders::where("status_id", 1)->where("stakeholder_id", Auth::user()->id)->first();

            $sql = "
                SELECT p.title product,s.business as supplier,d.product_id,d.order_id,sum(d.quantity) quantity,sum(d.quantity * d.value) total,p.image,p.thumbnail
                FROM orders_detail d
                    JOIN vproducts p ON p.id=d.product_id
                    JOIN stakeholder s ON s.id=p.supplier_id
                WHERE order_id=$order->id
                GROUP BY 1,2,3,4,product_id,p.image,d.id,p.thumbnail
                ORDER BY d.id";
            $detail = DB::select($sql);

            $total = 0;
            foreach ($detail as $i => $value) {
                $detail[$i]->formateTotal = "$ " . number_format($value->total, 2, ",", ".");
                $this->amount += $value->total;
            }
            return $detail;
        }
    }

    public function setQuantity(Request $req, $order_id) {
        $in = $req->all();

        $det = OrdersDetail::where("order_id", $order_id)->where("product_id", $in["product_id"])->first();
        $det->quantity = $in["quantity"];
        $det->save();
        return response()->json(["success" => true]);
    }

    public function responsePay(Request $req) {
        dd($_GET);
    }

    public function confirmationPay(Request $req) {
        echo "adsad";
        exit;
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

        $detail = DB::select($sql);
        $detail = json_decode(json_encode($detail), true);

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

        return redirect('listProducts');
    }

    public function payu(Request $req) {
        $pet = '{
                    "test": false,
                    "language": "en",
                    "command": "PING",
                    "merchant": {
                       "apiLogin": "pRRXKOl8ikMmt9u",
                       "apiKey": "4Vj8eK4rloUd272L48hsrarnUA"
                    }
                    }';


        $data = json_decode($pet, true);

        $pet2 = json_encode($data);


        $ch = curl_init("https://sandbox.api.payulatam.com/payments-api/4.0/service.cgi");
        //a true, obtendremos una respuesta de la url, en otro caso, 
        //true si es correcto, false si no lo es
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HEADER, array('Accept:application/json', 'Content-Type: application/json', 'Content-Length: ' . strlen($pet2)));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //establecemos el verbo http que queremos utilizar para la petición
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        //enviamos el array data
        curl_setopt($ch, CURLOPT_POSTFIELDS, $pet2);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, build_query($data));
        
        //obtenemos la respuesta
        $response = curl_exec($ch);

        curl_close($ch);

        print_r($response);
        exit;
    }

    public function deleteItem(Request $req, $id) {
        $input = $req->all();
        OrdersDetail::where("order_id", $id)->where("product_id", $input["product_id"])->delete();
        return response()->json($input);
    }

}
