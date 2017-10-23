<?php

namespace App\Http\Controllers\Payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Alexo\LaravelPayU\LaravelPayU;

class PaymentsController extends Controller {

    public function index() {

//        \Environment::setPaymentsCustomUrl("https://sandbox.api.payulatam.com/payments-api/4.0/service.cgi");
//        \Environment::setPaymentsCustomUrl("https://sandbox.gateway.payulatam.com/ppp-web-gateway");

        \Environment::setPaymentsCustomUrl("https://api.payulatam.com/payments-api/4.0/service.cgi");
        \Environment::setReportsCustomUrl("https://api.payulatam.com/reports-api/4.0/service.cgi");
        \Environment::setSubscriptionsCustomUrl("https://api.payulatam.com/payments-api/rest/v4.3/");

        \PayU::$apiKey = env('PAYU_API_KEY', '');
        \PayU::$apiLogin = env('PAYU_API_LOGIN', '');
        \PayU::$isTest = true;
        \PayU::$merchantId = env('PAYU_MERCHANT_ID', '');


//        LaravelPayU::doPing(function($response) {
//            dd($response);
//            $code = $response->code;
//
//            // ... revisar el codigo de respuesta
//        }, function($error) {
//            // ... Manejo de errores PayUException
//            dd($error);
//        });

        LaravelPayU::getPSEBanks(function($banks) {
            //... Usar datos de bancos
                 dd($banks);
            foreach ($banks as $bank) {
                $bankCode[] = $bank->pseCode;
            }
            dd($bankCode);
        }, function($error) {

            dd($error);
            // ... Manejo de errores PayUException, InvalidArgument
        });
    }

}
