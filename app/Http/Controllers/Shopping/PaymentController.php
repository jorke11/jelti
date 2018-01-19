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
//        $banks = $this->getMethodsPayments();
        $banks = array(array("id" => 1, "description" => "visa"), array("id" => 2, "description" => "mastercard"));
        $order = Orders::find($id);
        $user = Users::find($order->stakeholder_id);
        $client = Stakeholder::where("email", $user->email)->first();
//        dd($client);
        return view("Ecommerce.payment.payment", compact("id", "banks", "client"));
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

    public function responsePay(Request $req) {
        dd($_GET);
    }

    public function confirmationPay(Request $req) {
        echo "adsad";
        exit;
    }

    public function payment(Request $req) {

        $in = $req->all();

        $detail = $this->getDetailData();
//
//
        $client = Stakeholder::where("email", Auth::user()->email)->first();
////        echo "<pre>";
////        print_r(Auth::user()->email);
////        print_r($client);
////        exit;
//        $url = "https://sandbox.api.payulatam.com/payments-api/4.0/service.cgi";
        $apiKey = "4Vj8eK4rloUd272L48hsrarnUA";
        $apiKey = "maGw8KQ5JlOEv64D79ma1N0l9G";
        $apiLogin = "pRRXKOl8ikMmt9u";
////$apiLogin = "rHpg9EL98w905Nv";
        $merchantId = "508029";
        $accountId = "512321";
        $referenceCode = "Superfuds0000004";
        $tx_value = $this->total;
        $session_id = md5(session_id() . microtime());
        $currency = "COP";
        $postData["test"] = "false";
        $postData["language"] = "en";
        $postData["command"] = "SUBMIT_TRANSACTION";

        $postData["merchant"] = array(
            "apiKey" => $apiKey,
            "apiLogin" => $apiLogin
        );
//
////        $signature = md5($apiKey . "~" . $merchantId . "~" . $referenceCode . "~" . $tx_value . "~" . $currency);
        $signature = md5($apiKey . "~" . $merchantId . "~" . $referenceCode . "~" . $tx_value . "~" . $currency);
////        echo "<pre>";
////        print_r($client);
//
//        $city = \App\Models\Administration\Cities::find($client->city_id);
//        $department = \App\Models\Administration\Department::find($city->department_id);
//
        $type_card = $this->identifyCard($in["target_number"], $in["crc"], $in["expirate"]);


        $deviceSessionId = md5(session_id() . microtime());
//
//        if ($type_card != false) {
//            $postData["transaction"] = array("order" => array(
//                    "accountId" => $accountId,
//                    "referenceCode" => $referenceCode,
//                    "description" => "payment " . $client->business,
//                    "language" => "es",
//                    "signature" => $signature,
//                    "notifyUrl" => "http://localhost:8080/payu/tarjetas_credito.php",
//                    "additionalValues" => array(
////                    "TX_VALUE" => array("value" => $tx_value, "currency" => $currency),
//                        "TX_VALUE" => array("value" => $this->total, "currency" => $currency),
//                        "TX_TAX" => array("value" => 3193, "currency" => $currency),
//                        "TX_TAX_RETURN_BASE" => array("value" => 16806, "currency" => $currency),
//                    ),
//                    "buyer" => array(
//                        "merchantBuyerId" => "1",
//                        "fullName" => $client->business,
//                        "emailAddress" => $client->email,
//                        "contactPhone" => $client->phone,
//                        "dniNumber" => $client->document,
//                        "shippingAddress" => array(
//                            "street1" => $client->address_send,
////                        "street2" => "5555487",
//                            "city" => $city->description,
//                            "state" => $department->description,
//                            "country" => "CO",
//                            "postalCode" => "000000",
//                            "phone" => $client->phone
//                        )
//                    ),
//                    "shippingAddress" => array(
//                        "street1" => $client->address_send,
////                        "street2" => "5555487",
//                        "city" => $city->description,
//                        "state" => $department->description,
//                        "country" => "CO",
//                        "postalCode" => "000000",
//                        "phone" => $client->phone
//                    )
//                ),
//                "payer" => array(
//                    "merchantPayerId" => "1",
//                    "fullName" => $client->business,
//                    "emailAddress" => $client->emails,
//                    "contactPhone" => $client->phone,
//                    "dniNumber" => $client->document,
//                    "billingAddress" => array(
//                        "street1" => $client->address_send,
////                        "street2" => "5555487",
//                        "city" => $city->description,
//                        "state" => $department->description,
//                        "country" => "CO",
//                        "postalCode" => "000000",
//                        "phone" => $client->phones
//                    )
//                ),
//                "creditCard" => array(
//                    "number" => $in["target_number"],
//                    "securityCode" => $in["crc"],
////                "expirationDate" => "2018/12",
//                    "expirationDate" => $in["expirate"],
//                    "name" => "REJECTED"
//                ),
//                "extraParameters" => array(
//                    "INSTALLMENTS_NUMBER" => 1
//                ),
//                "type" => "AUTHORIZATION_AND_CAPTURE",
//                "paymentMethod" => $type_card["paymentMethod"],
//                "paymentCountry" => "CO",
//                "deviceSessionId" => $deviceSessionId,
//                "ipAddress" => $_SERVER["REMOTE_ADDR"],
//                "cookie" => "pt1t38347bs6jc9ruv2ecpv7o2",
//                "userAgent" => "Mozilla/5.0 (Windows NT 5.1; rv:18.0) Gecko/20100101 Firefox/18.0"
//            );
//        } else {
//            $postData["error"] = "Datos no validos";
//        }
//
//        echo "<pre>";
//        print_r($postData);
//
//        echo "<br>";
//        echo "Respuesta ......<br>";
//
//        $data_string = json_encode($postData);
//
//
//
//        $ch = curl_init($url);
//        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//            'Content-Type: application/json',
//            'Host: sandbox.api.payulatam.com',
//            'Accept:application/json',
//            'Content-Length: ' . strlen($data_string))
//        );
////print_r($data_string);exit;                        
//
//        $result = curl_exec($ch);
//
//        $arr = json_decode($result, TRUE);
//        echo "<pre>";
//        print_r($arr);












        $url = "https://sandbox.api.payulatam.com/payments-api/4.0/service.cgi";
        $apiKey = "4Vj8eK4rloUd272L48hsrarnUA";
//$apiKey = "maGw8KQ5JlOEv64D79ma1N0l9G";
        $apiLogin = "pRRXKOl8ikMmt9u";
//$apiLogin = "rHpg9EL98w905Nv";
        $merchantId = "508029";
        $accountId = "512321";
        $referenceCode = "Superfuds000000113";
        $tx_value = 20000;
        $session_id = md5(session_id() . microtime());
        $currency = "COP";
        $postData["test"] = "false";
        $postData["language"] = "en";
        $postData["command"] = "SUBMIT_TRANSACTION";

        $postData["merchant"] = array(
            "apiKey" => $apiKey,
            "apiLogin" => $apiLogin
        );


        $signature = md5($apiKey . "~" . $merchantId . "~" . $referenceCode . "~" . $tx_value . "~" . $currency);

        $postData["transaction"] = array("order" => array(
                "accountId" => $accountId,
                "referenceCode" => $referenceCode,
                "description" => "payment " . $client->business,
                "language" => "es",
                "signature" => $signature,
                "notifyUrl" => "http://localhost:8080/payu/tarjetas_credito.php",
                "additionalValues" => array(
                    "TX_VALUE" => array("value" => $tx_value, "currency" => $currency),
                    "TX_VALUE" => array("value" => $this->total, "currency" => $currency),
                    "TX_TAX" => array("value" => 10, "currency" => $currency),
                    "TX_TAX_RETURN_BASE" => array("value" => 16806, "currency" => $currency),
                ),
                "buyer" => array(
                    "merchantBuyerId" => "1",
                    "fullName" => "First name and second buyer  name",
                    "emailAddress" => "jpinedom@hotmail.com",
                    "contactPhone" => "7563126",
                    "dniNumber" => "5415668464654",
                    "shippingAddress" => array(
                        "street1" => "calle 100",
                        "street2" => "5555487",
                        "city" => "Medellin",
                        "state" => "Antioquia",
                        "country" => "CO",
                        "postalCode" => "000000",
                        "phone" => "7563126"
                    )
                ),
                "shippingAddress" => array(
                    "street1" => "calle 100",
                    "street2" => "5555487",
                    "city" => "Medellin",
                    "state" => "Antioquia",
                    "country" => "CO",
                    "postalCode" => "0000000",
                    "phone" => "7563126"
                )
            ),
            "payer" => array(
                "merchantPayerId" => "1",
                "fullName" => "First name and second payer name",
                "emailAddress" => "payer_test@test.com",
                "contactPhone" => "7563126",
                "dniNumber" => "5415668464654",
                "billingAddress" => array(
                    "street1" => "calle 93",
                    "street2" => "125544",
                    "city" => "Bogota",
                    "state" => "Bogota DC",
                    "country" => "CO",
                    "postalCode" => "000000",
                    "phone" => "7563126"
                )
            ),
            "creditCard" => array(
                "number" => $in["target_number"],
                "securityCode" => $in["crc"],
//                "expirationDate" => "2018/12",
                "expirationDate" => $in["expirate"],
                "name" => "REJECTED"
            ),
            "extraParameters" => array(
                "INSTALLMENTS_NUMBER" => 1
            ),
            "type" => "AUTHORIZATION_AND_CAPTURE",
            "paymentMethod" => $type_card["paymentMethod"],
            "paymentCountry" => "CO",
            "deviceSessionId" => $deviceSessionId,
            "ipAddress" => $_SERVER["REMOTE_ADDR"],
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
    }

    public function identifyCard($number, $cvc, $expire) {
        $response = false;

        if (preg_match('/[0-9]{4,}\/[0-9]{2,}$/', $expire)) {
            //Mastercard
            if (strlen($number) == 15 && strlen($cvc) == 4) {


                if (preg_match('/^5[1-5][0-9]{5,}|222[1-9][0-9]{3,}|22[3-9][0-9]{4,}|2[3-6][0-9]{5,}|27[01][0-9]{4,}|2720[0-9]{3,}$/', trim($number))) {

                    $response = array("paymentMethod" => 'Mastercard', "status" => true);
                }
            }

            //VISA
            if (strlen($number) == 16 && strlen($cvc) == 3) {
                if (preg_match('/^4[0-9]{6,}$/', $number)) {
                    $response = array("paymentMethod" => 'VISA', "status" => true);
                }
            }

            //American express
            if (strlen($number) == 15 && strlen($cvc) == 4) {

                if (preg_match('/^3[47][0-9]{5,}$/', $number)) {
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
