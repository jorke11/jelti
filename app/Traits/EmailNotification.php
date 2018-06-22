<?php

namespace App\Traits;

use DB;
use Auth;
use App\Models\Inventory\Departures;
use App\Models\Administration\Warehouses;
use App\Models\Security\Users;
use App\Models\Administration\Stakeholder;
use App\Models\Administration\Email;
use App\Models\Administration\EmailDetail;
use App\Models\Administration\Cities;
use Mail;

trait EmailNotification {

    public function __construct() {
        
    }

    public function sendRequestOrder($departure_id) {

        $header = Departures::find($departure_id);

        $ware = Warehouses::find($header->warehouse_id);
        $client = Stakeholder::find($header->client_id);

        $email = Email::where("description", "departures")->first();


        if ($email != null) {
            $emDetail = EmailDetail::where("email_id", $email->id)->get();
        }

        if (count($emDetail) > 0) {
            $mails = array();


            $userware = Users::find($ware->responsible_id);
            $mails[] = $userware->email;

            foreach ($emDetail as $value) {
                $mails[] = $value->description;
            }

            $cit = Cities::find($ware->city_id);
            $subject = "SuperFuds " . date("d/m") . " " . $client->business . " " . $cit->description . " " . $departure_id;
            $user = Users::find($header->responsible_id);

            $mails[] = $user->email;

            $param["id"] = $departure_id;
            $param["environment"] = env("APP_ENV");
            $param["subtotal"] = "$" . number_format($header->subtotal, 0, ",", ".");
            $param["total"] = "$" . number_format($header->total, 0, ",", ".");
            $param["exento"] = $header->exento;
            $param["tax5"] = $header->tax5;
            $param["tax19"] = $header->tax19;
            $param["flete"] = $header->shipping_cost;
            $param["discount"] = $header->discount;
            $param["status_id"] = $header->status_id;
            $param["created_at"] = $header->created_at;
            $param["detail"] = $this->formatDetail($departure_id);
            $param["warehouse"] = $ware->description;

            if ($header["environment"] == 'local') {
                $mails = Auth::User()->email;
            }


            Mail::send("Notifications.departure", $param, function($msj) use($subject, $mails) {
                $msj->subject($subject);
                $msj->to($mails);
            });
        }
    }

}
