<?php

namespace App\Http\Controllers\Ecommerce;

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
use Log;
use App\Models\Inventory\Departures;
use App\Models\Inventory\DeparturesDetail;
use App\Models\Administration\PricesSpecial;
use App\Models\Administration\Products;
use App\Traits\ValidateCreditCard;

class PaymentController extends Controller {

    use ValidateCreditCard;

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

            $detail = $this->formatedDetail($detail);

            $total = "$" . number_format($this->total, 0, ",", ".");
            $subtotal = "$" . number_format($this->subtotal, 0, ",", ".");
            $tax5 = "$" . number_format($this->tax5, 0, ",", ".");
            $tax19 = "$" . number_format($this->tax19, 0, ",", ".");

            return response()->json(["detail" => $detail, "total" => $total, "exento" => $this->exento, "subtotal" => $subtotal,
                        "order" => $this->order_id, "totalnumeric" => $this->total, 'tax5' => $tax5, "tax19" => $tax19]);
        } else {
            return response()->json(["success" => false, "total" => 0, "subtotal" => 0]);
        }
    }

    public function formatedDetail($detail) {
        $this->total = 0;
        $this->subtotal = 0;

        if (count($detail) > 0) {
            foreach ($detail as $i => $value) {
//            echo "<pre>";
//            print_r($value);
//            exit;
                $detail[$i]["valueFormated"] = "$" . number_format($value["value"], 0, ",", ".");
                $detail[$i]["total"] = $detail[$i]["quantity"] * $detail[$i]["value"] * $detail[$i]["units_sf"];
                $detail[$i]["totalFormated"] = "$" . number_format($detail[$i]["total"], 0, ",", ".");
                $this->subtotal += $detail[$i]["total"];


                $this->total += $detail[$i]["total"] + ($detail[$i]["total"] * $value["tax"]);


                if ($value["tax"] == 0) {
                    $this->exento += $detail[$i]["total"];
                }
                if ($value["tax"] == 0.05) {
                    $this->tax5 += $detail[$i]["total"] * $value["tax"];
                }
                if ($value["tax"] == 0.19) {
                    $this->tax19 += $detail[$i]["total"] * $value["tax"];
                }
            }
            return $detail;
        } else {
            return false;
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

        $countries[] = array("code" => "CO", "description" => "Colombia");


        $order = Orders::find($id);
        $user = Users::find($order->stakeholder_id);
        $client = Stakeholder::where("email", $user->email)->first();
        $detail = $this->getDetailData();



        $detail = $this->formatedDetail($detail);

        if ($detail) {
            $total = "$" . number_format($this->total, 0, ",", ".");
            $subtotal = "$" . number_format($this->subtotal, 0, ",", ".");

            $deviceSessionId = md5(session_id() . microtime());
            $deviceSessionId_concat = $deviceSessionId . "80200";

            return view("Ecommerce.payment.payment", compact("id", "client", "month", "years", "total", "countries", "subtotal", "deviceSessionId", "deviceSessionId_concat"));
        } else {
            return redirect('ecommerce/0')->with("error", "Informacion no existe");
        }
    }

    public function getDetailData() {
        $detail = null;
        if (Auth::user() != null) {
            $this->order = Orders::where("status_id", 1)->where("stakeholder_id", Auth::user()->id)->first();
            if ($this->order != null) {
                $this->order_id = $this->order->id;
                $sql = "
                SELECT p.title product,s.business as supplier,d.product_id,d.order_id,sum(d.quantity) quantity,d.value as value,sum(d.quantity * d.value) total,p.image,p.thumbnail,
                d.units_sf,d.tax
                FROM orders_detail d
                    LEFT JOIN vproducts p ON p.id=d.product_id
                    LEFT JOIN stakeholder s ON s.id=p.supplier_id
                WHERE order_id=" . $this->order->id . "
                GROUP BY 1,2,3,4,d.units_sf,product_id,p.image,d.tax,p.thumbnail,d.value
                ORDER BY 1";
//                echo $sql;exit;
                $detail = DB::select($sql);

                $detail = json_decode(json_encode($detail), true);

//                echo "<pre>";print_r($detail);exit;
                return $detail;
            } else {
                return null;
            }
        }
    }

    public function setQuantity(Request $req, $order_id) {
        $in = $req->all();

        $det = OrdersDetail::where("order_id", $order_id)->where("product_id", $in["product_id"])->get();
        foreach ($det as $value) {
            $row = OrdersDetail::find($value->id);
            $row->delete();
        }

        $pro = \App\Models\Administration\Products::find($in["product_id"]);

        for ($i = 0; $i < $in["quantity"]; $i++) {
            $new["order_id"] = $order_id;
            $new["product_id"] = $in["product_id"];
            $new["tax"] = $pro->tax;
            $new["value"] = $pro->price_sf;
            $new["units_sf"] = $pro->units_sf;
            $new["quantity"] = 1;
            OrdersDetail::create($new);
        }

        return response()->json(["success" => true]);
    }

    public function createOrder() {
        $row = Orders::where("status_id", 1)->where("stakeholder_id", Auth::user()->id)->first();

        $user = Users::find(Auth::user()->id);

        $client = Stakeholder::find($user->stakeholder_id);

        $new["warehouse_id"] = 3;
        $new["responsible_id"] = 1;
        $new["city_id"] = $client->city_id;
        $new["created"] = date("Y-m-d H:i");
        $new["status_id"] = 1;
        $new["client_id"] = $user->stakeholder_id;
        $new["destination_id"] = $client->city_id;
        $new["address"] = $client->address_send;
        $new["phone"] = $client->phone;
        $new["shipping_cost"] = 0;
        $new["insert_id"] = Auth::user()->id;
//        $new["type_insert_id"] = 2;
        $new["order_id"] = $row->id;
        $detail = $this->getDetailData();

        $res = $this->depObj->processDeparture($new, $detail)->getData();
        return $res;
    }

    public function payment(Request $req) {
//        dd($_SERVER["HTTP_USER_AGENT"]);
        try {
            DB::beginTransaction();
            $in = $req->all();

            $country = $in["country_id"];
            $in["expirate"] = $in["year"] . "/" . $in["month"];

            $data_order = $this->createOrder();
//        dd($data_order);
            $detail = $this->getDetailData();

            $client = Stakeholder::where("email", Auth::user()->email)->first();

            $city = \App\Models\Administration\Cities::find($client->city_id);
            $department = \App\Models\Administration\Department::find($city->department_id);
//
            $type_card = $this->identifyCard($in["number"], $in["crc"], $in["expirate"]);

            $error = '';


            if ($type_card["status"] == false) {
                $error = $type_card["msg"];
            }

            if ($error == '') {

                $deviceSessionId = $in["devicesessionid"];
//                $deviceSessionId = md5(session_id() . microtime());

                $url = "https://sandbox.api.payulatam.com/payments-api/4.0/service.cgi";
                $apiKey = "4Vj8eK4rloUd272L48hsrarnUA";
//$apiKey = "maGw8KQ5JlOEv64D79ma1N0l9G";
                $apiLogin = "pRRXKOl8ikMmt9u";
//$apiLogin = "rHpg9EL98w905Nv";
                $merchantId = "508029";
                $accountId = "512321";
                $referenceCode = 'invoice_' . microtime();

                $TX_VALUE = round($data_order->header->total);
                $TX_TAX = 0;
                $TX_TAX_RETURN_BASE = 0;

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

                $buyer_full_name = $client->business;
                $buyer_email = $client->email;
                $buyer_document = $client->document;
                $buyer_address = $client->address_invoice;
                $buyer_phone = $client->phone;
                $buyer_city = $client->description;
                $buyer_department = $department->description;


                if (!isset($in["checkbuyer"])) {
                    $city_buyer = \App\Models\Administration\Cities::find($in["city_buyer_id"]);
                    $department_buyer = \App\Models\Administration\Department::find($in["department_buyer_id"]);
                    if ($in["name_buyer"] != '') {
                        $buyer_full_name = $in["name_buyer"];
                    }
                    if ($in["email_buyer"] != '') {
                        $buyer_email = $in["email_buyer"];
                    }
                    if ($in["document_buyer"] != '') {
                        $buyer_document = $in["document_buyer"];
                    }
                    if ($in["addrees_buyer"] != '') {
                        $buyer_address = $in["addrees_buyer"];
                    }
                    if ($in["addrees_buyer"] != '') {
                        $buyer_phone = $in["phone_buyer"];
                    }
                    if ($in["city_buyer_id"] != '') {
                        $buyer_city = $city_buyer->description;
                    }
                    if ($in["department_buyer_id"] != '') {
                        $buyer_department = $department_buyer->description;
                    }
                }

                $payer_fullName = $postData["transaction"] = array("order" => array(
                        "accountId" => $accountId,
                        "referenceCode" => $referenceCode,
                        "description" => "Pago " . $referenceCode,
                        "language" => "es",
                        "signature" => $signature,
//                    "notifyUrl" => "http://localhost:8080/payu/tarjetas_credito.php",
                        "notifyUrl" => "",
                        "additionalValues" => array(
                            "TX_VALUE" => array("value" => $TX_VALUE, "currency" => $currency),
                            "TX_TAX" => array("value" => $TX_TAX, "currency" => $currency),
                            "TX_TAX_RETURN_BASE" => array("value" => $TX_TAX_RETURN_BASE, "currency" => $currency),
                        ),
                        "buyer" => array(
                            "merchantBuyerId" => "1",
                            "fullName" => $buyer_full_name,
                            "emailAddress" => $buyer_email,
                            "contactPhone" => $buyer_phone,
                            "dniNumber" => $buyer_document,
                            "shippingAddress" => array(
                                "street1" => $buyer_address,
//                        "street2" => "5555487",
                                "city" => $buyer_city,
                                "state" => $buyer_department,
                                "country" => $country,
                                "postalCode" => "000000",
                                "phone" => $buyer_phone
                            )
                        ),
                        "shippingAddress" => array(
                            "street1" => $buyer_address,
//                        "street2" => "5555487",
                            "city" => $buyer_city,
                            "state" => $buyer_department,
                            "country" => $country,
                            "postalCode" => "000000",
                            "phone" => $buyer_phone
                        )
                    ),
                    "payer" => array(
                        "merchantPayerId" => $client->id,
                        "fullName" => $client->business,
                        "emailAddress" => $client->email,
                        "contactPhone" => $client->phone,
                        "dniNumber" => $client->document,
                        "billingAddress" => array(
                            "street1" => $client->address_send,
//                        "street2" => "5555487",
                            "city" => $city->description,
                            "state" => $department->description,
                            "country" => $country,
                            "postalCode" => "000000",
                            "phone" => $client->phone
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
                        "INSTALLMENTS_NUMBER" => $in["dues"]
                    ),
                    "type" => "AUTHORIZATION_AND_CAPTURE",
//            "paymentMethod" => "VISA",
                    "paymentMethod" => $type_card["paymentMethod"],
                    "paymentCountry" => $country,
//            "deviceSessionId" => "vghs6tvkcle931686k1900o6e1",
                    "deviceSessionId" => $deviceSessionId,
                    "ipAddress" => $_SERVER["REMOTE_ADDR"],
                    "cookie" => "",
//                "userAgent" => "Mozilla/5.0 (Windows NT 5.1; rv:18.0) Gecko/20100101 Firefox/18.0"
                    "userAgent" => $_SERVER["HTTP_USER_AGENT"]
                );

//        Log::info(print_r($postData, true));
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
//            dd(json_decode($data_string, TRUE));

                $result = curl_exec($ch);

                $arr = json_decode($result, TRUE);

                if ($arr["transactionResponse"]["responseCode"] == 'APPROVED') {

                    $row = Departures::find($data_order->header->id);
                    $row->paid_out = true;
                    $row->type_request = "ecommerce";

                    $row->save();

                    $row_order = Orders::find($row->order_id);
                    $row_order->response_payu = $result;
                    $row_order->status_id = 2;
                    $row_order->save();

                    return redirect('ecommerce/0')->with("success", 'Compra Realizada! Orden #' . $arr["transactionResponse"]["orderId"]);
                } else if ($arr["transactionResponse"]["state"] == 'PENDING') {
                    $row = Departures::find($data_order->header->id);
                    $row->paid_out = false;
                    $row->type_request = "ecommerce";

                    $row->save();

                    $row_order = Orders::find($row->order_id);
                    $row_order->response_payu = $result;
                    $row_order->status_id = 3;
                    $row_order->save();

                    return redirect('ecommerce/0')
                                    ->with("success", 'En un tiempo de aproximado de 4 Horas te llegará la notificación del pago mientras realizamos validaciones de seguridad, gracias por preferirnos')
                                    ->with("order_id", $arr["transactionResponse"]["orderId"]);
                } else {
                    $error = $arr["error"];
                    if ($arr["code"] == 'SUCCESS') {
                        if ($arr["transactionResponse"]["state"] == 'DECLINED') {
                            $error = "Por favor verifique la informacion de la Tarjeta de credito, vuelve a intentarlo. Orden Id #" . $arr["transactionResponse"]["orderId"] . "";
                        } else {
                            $error = $arr["transactionResponse"]["responseMessage"];
                        }
                        DB::rollback();
                    } else {
                        $error = "Tarjeta no aceptada en nuestro Sistema";
                    }

                    return back()->with("error", $error);
                }
            } else {
                return back()->with("error", $error);
            }
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["success" => false], 409);
        }
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

        return redirect('ecommerce/0')->with("success", 'Payment success');
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

        return response()->json(["status" => true, "order" => $id]);
    }

}
