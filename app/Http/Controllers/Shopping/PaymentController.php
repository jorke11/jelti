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
use App\Models\Security\Users;

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
    public $total;
    public $subtotal;
    public $tax5;
    public $tax19;
    public $exento;
    public $order_id;
    public $order;

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
        $this->order_id = 0;
    }

    public function index() {
        $client = Stakeholder::where("document", Auth::user()->document)->first();
//        dd($client);
        return view("Ecommerce.payment.init", compact("client"));
    }

    public function getMethodsPayments() {
        $url = "https://sandbox.api.payulatam.com/payments-api/4.0/service.cgi ";
        $postData = array(
            "test" => "false",
            "language" => "es",
            "command" => "GET_PAYMENT_METHODS",
            "merchant" => array("apiLogin" => "pRRXKOl8ikMmt9u", "apiKey" => "4Vj8eK4rloUd272L48hsrarnUA"));


        $data_string = json_encode($postData);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json;',
            'Host: sandbox.api.payulatam.com',
            'Accept:application/json',
            'Content-Length: ' . strlen($data_string))
        );
//print_r($data_string);exit;                        

        $result = curl_exec($ch);
        $arr = json_decode($result, TRUE);
        $banks = [];


        dd($arr);
        foreach ($arr["paymentMethods"] as $val) {
            if ($val["country"] == 'CO') {
                $banks[] = $val;
            }
        }

        return $banks;
    }

    public function generatekey() {
        $key = md5($this->ApiKey . "~" . $this->merchantId . "~" . $this->referenceCode . "~" . $this->currency);
        return response()->json(["key" => $key]);
    }

    public function getDetail() {
        $detail = $this->getDetailData();
        if ($detail != null) {
            $total = "$" . number_format($this->total, 0, ",", ".");
            $subtotal = "$" . number_format($this->subtotal, 0, ",", ".");
            return response()->json(["detail" => $detail, "total" => $total, "exento" => $this->exento, "subtotal" => $subtotal, "order" => $this->order_id]);
        } else {
            return response()->json(["success" => false, "total" => 0], 509);
        }
    }

    public function methodsPayment($id) {
        $month = array();
        for ($i = 1; $i <= 12; $i++) {
            if ($i <= 9) {
                $month[] = "0" . $i;
            } else {
                $month[] = "" . $i;
            }
        }

        $years = array();

        for ($i = (int) date("Y"); $i <= date("Y") + 10; $i++) {
            $years[] = $i;
        }


        $order = Orders::find($id);
        $user = Users::find($order->stakeholder_id);
        $client = Stakeholder::where("email", $user->email)->first();

        return view("Ecommerce.payment.payment", compact("id", "client", "month", "years"));
    }

    public function getDetailData() {
        $detail = null;
        if (Auth::user() != null) {
            $this->order = Orders::where("status_id", 1)->where("stakeholder_id", Auth::user()->id)->first();
            $this->order_id = $this->order->id;

            $sql = "
                SELECT p.title product,s.business as supplier,d.product_id,d.order_id,sum(d.quantity) quantity,sum(d.value) as value,sum(d.quantity * d.value) total,p.image,p.thumbnail,
                sum(d.units_sf) as units_sf,d.tax
                FROM orders_detail d
                    JOIN vproducts p ON p.id=d.product_id
                    JOIN stakeholder s ON s.id=p.supplier_id
                WHERE order_id=" . $this->order->id . "
                GROUP BY 1,2,3,4,product_id,p.image,d.id,p.thumbnail
                ORDER BY d.id";
//            echo $sql;exit;

            $detail = DB::select($sql);

            $this->total = 0;
            $this->subtotal = 0;
            foreach ($detail as $i => $value) {
                $detail[$i]->valueFormated = "$" . number_format($value->value, 0, ",", ".");
                $detail[$i]->total = $detail[$i]->quantity * $detail[$i]->value * $detail[$i]->units_sf;

                $detail[$i]->totalFormated = "$" . number_format($detail[$i]->total, 0, ",", ".");
                $this->subtotal += $detail[$i]->total;

                $this->total += $detail[$i]->total + ($detail[$i]->total * $value->tax);

                if ($value->tax == 0) {
                    $this->exento += $detail[$i]->total;
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

    public function setQuantity(Request $req, $order_id) {
        $in = $req->all();

        $det = OrdersDetail::where("order_id", $order_id)->where("product_id", $in["product_id"])->first();
        $det->quantity = $in["quantity"];
        $det->save();
        return response()->json(["success" => true]);
    }

    public function payment(Request $req) {

        $in = $req->all();

        $in["expirate"] = $in["year"] . "/" . $in["month"];
        $detail = $this->getDetailData();
        $client = Stakeholder::where("email", Auth::user()->email)->first();

        $city = \App\Models\Administration\Cities::find($client->city_id);
        $department = \App\Models\Administration\Department::find($city->department_id);
//
        $type_card = $this->identifyCard($in["number"], $in["crc"], $in["expirate"]);

        if ($type_card == false) {
            exit("Tarjeta no reconocida");
        }


        $deviceSessionId = md5(session_id() . microtime());

        $url = "https://sandbox.api.payulatam.com/payments-api/4.0/service.cgi";
        $apiKey = "4Vj8eK4rloUd272L48hsrarnUA";
//$apiKey = "maGw8KQ5JlOEv64D79ma1N0l9G";
        $apiLogin = "pRRXKOl8ikMmt9u";
//$apiLogin = "rHpg9EL98w905Nv";
        $merchantId = "508029";
        $accountId = "512321";
        $referenceCode = 'invioce_004';

        $TX_VALUE = $this->total;
        $TX_TAX = 0.19;
        $TX_TAX_RETURN_BASE = 1000;

        $session_id = md5(session_id() . microtime());
        $currency = "COP";
        $postData["test"] = "true";
        $postData["language"] = "en";
        $postData["command"] = "SUBMIT_TRANSACTION";

        $postData["merchant"] = array(
            "apiKey" => $apiKey,
            "apiLogin" => $apiLogin
        );

        $signature = md5($apiKey . "~" . $merchantId . "~" . $referenceCode . "~" . $TX_VALUE . "~" . $currency);

        $postData["transaction"] = array("order" => array(
                "accountId" => $accountId,
                "referenceCode" => $referenceCode,
                "description" => "Pago " . $referenceCode,
                "language" => "es",
                "signature" => $signature,
                "notifyUrl" => "http://localhost:8080/payu/tarjetas_credito.php",
                "additionalValues" => array(
                    "TX_VALUE" => array("value" => $TX_VALUE, "currency" => $currency),
                    "TX_TAX" => array("value" => $TX_TAX, "currency" => $currency),
                    "TX_TAX_RETURN_BASE" => array("value" => $TX_TAX_RETURN_BASE, "currency" => $currency),
                ),
                "buyer" => array(
                    "merchantBuyerId" => "1",
                    "fullName" => $client->business,
                    "emailAddress" => $client->email,
                    "contactPhone" => $client->phone,
                    "dniNumber" => $client->document,
                    "shippingAddress" => array(
                        "street1" => $client->address_send,
//                        "street2" => "5555487",
                        "city" => $city->description,
                        "state" => $department->description,
                        "country" => "CO",
                        "postalCode" => "000000",
                        "phone" => $client->phone
                    )
                ),
                "shippingAddress" => array(
                    "street1" => $client->address_send,
//                        "street2" => "5555487",
                    "city" => $city->description,
                    "state" => $department->description,
                    "country" => "CO",
                    "postalCode" => "000000",
                    "phone" => $client->phone
                )
            ),
            "payer" => array(
                "merchantPayerId" => "1",
                "fullName" => $client->business,
                "emailAddress" => $client->email,
                "contactPhone" => $client->phone,
                "dniNumber" => $client->document,
                "billingAddress" => array(
                    "street1" => $client->address_send,
//                        "street2" => "5555487",
                    "city" => $city->description,
                    "state" => $department->description,
                    "country" => "CO",
                    "postalCode" => "000000",
                    "phone" => $client->phones
                )
            ),
            "creditCard" => array(
//                "number" => "4097440000000004",
                "number" => $in["number"],
//                "securityCode" => "321",
                "securityCode" => $in["crc"],
//                "expirationDate" => "2019/02",
                "expirationDate" => $in["expirate"],
                "name" => $in["name"]
            ),
            "extraParameters" => array(
                "INSTALLMENTS_NUMBER" => 1
            ),
            "type" => "AUTHORIZATION_AND_CAPTURE",
//            "paymentMethod" => "VISA",
            "paymentMethod" => $type_card["paymentMethod"],
            "paymentCountry" => "CO",
//            "deviceSessionId" => "vghs6tvkcle931686k1900o6e1",
            "deviceSessionId" => $deviceSessionId,
            "ipAddress" => "127.0.0.1",
            "cookie" => "pt1t38347bs6jc9ruv2ecpv7o2",
            "userAgent" => "Mozilla/5.0 (Windows NT 5.1; rv:18.0) Gecko/20100101 Firefox/18.0"
        );
        echo "<pre>";
        print_r($postData);
        echo "<br>";
        echo "Respuesta ......<br>";

        $data_string = json_encode($postData);



        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Host: sandbox.api.payulatam.com',
            'Accept:application/json',
            'Content-Length: ' . strlen($data_string))
        );
//print_r($data_string);exit;                        

        $result = curl_exec($ch);

        $arr = json_decode($result, TRUE);
        echo "<pre>";
        print_r($arr);

//        if ($arr["transactionResponse"]["responseCode"] == 'APPROVED') {
//            return redirect('shopping/0')->with("success", 'Payment success');
//        }
    }

    public function paymentCredit(Request $req) {
        $in = $req->all();

        $this->processPayment($in["order_id"]);
    }

    public function processPayment($id) {
//        $order = Orders::where("status_id", 1)->where("stakeholder_id", Auth::user()->id)->first();
        $order = Orders::where("status_id", 1)->where("id", $id)->first();

        $stake = Stakeholder::find($order->stakeholder_id);

        dd($stake);

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

        return redirect('shopping/0')->with("success", 'Payment success');
    }

    public function identifyCard($number, $cvc, $expire) {
        $response = false;

        if (preg_match('/[0-9]{4,}\/[0-9]{2,}$/', $expire)) {
            
            //VISA
            if (strlen($number) == 16 && strlen($cvc) == 3) {
//                if (preg_match('/^4[0-9]{6,}$/', $number)) {
                if (preg_match('/^(4)(\\d{12}|\\d{15})$|^(606374\\d{10}$)/', $number)) {
                    $response = array("paymentMethod" => 'VISA', "status" => true);
                }
            }
            
              //Dinnesrs

            if (strlen($number) == 15 && strlen($cvc) == 4) {
                if (preg_match('/^[35](?:0[0-5|[68][0-9]{11}$)|(^30[0-5]{11}$)|(^3095(\\d{10}$)|(^3[89](\\d{12})$/', trim($number))) {
                    $response = array("paymentMethod" => 'Dinners', "status" => true);
                }
            }


            //Mastercard

            if (strlen($number) == 15 && strlen($cvc) == 4) {

//                if (preg_match('/^5[1-5][0-9]{5,}|222[1-9][0-9]{3,}|22[3-9][0-9]{4,}|2[3-6][0-9]{5,}|27[01][0-9]{4,}|2720[0-9]{3,}$/', trim($number))) {
                if (preg_match('/^(5[1-5]\\d{14}$)|^(2(?:2(?:2[1-9]|[3-9]\\d)|[3-6]\\d\\dd|7(?:[01]\\d|20))\\d{12}$)/', trim($number))) {
                    $response = array("paymentMethod" => 'Mastercard', "status" => true);
                }
            }



            //American express
            if (strlen($number) == 15 && strlen($cvc) == 4) {

//                if (preg_match('/^3[47][0-9]{5,}$/', $number)) {
                if (preg_match('/^3[47]\\d{13}$/', $number)) {
                    $response = array("paymentMethod" => 'AMEX', "status" => true);
                }
            }
        } else {
            $response = array("status" => true, "msg" => "Fecha de Expiracion invalida");
        }

        return $response;
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
