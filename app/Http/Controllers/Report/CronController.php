<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Administration\Email;
use App\Models\Administration\EmailDetail;
use Mail;
use Auth;

class CronController extends Controller {

    function emailoverview() {
        $environment = 'production';
        $date_report = date("Y-m-d");
        $init = $date_report . " 00:00";
        $end = $date_report . " 23:59";
        $new = DB::table("vdepartures")
                ->whereBetween("created_at", array($init, $end))
                ->where("status_id", 1)
                ->orderBy("responsible")
                ->get();
        $arrnew = array();
        $cont = 0;
        $group = array();
        foreach ($new as $i => $value) {
            if ($i == 0) {
                $group = $value;
            }

            if ($i > 0) {
                if ($new[$i - 1]->responsible != $value->responsible) {
                    $cont++;
                    $group = $value;
                } else {
                    $group = $value;
                }
            }

            $arrnew[$cont][] = $group;
            $group = array();
        }

        $pend = DB::table("vdepartures")
                ->whereBetween("created_at", array($init, $end))
                ->where("status_id", 2)
                ->orderBy("responsible")
                ->get();

        $arrpend = array();
        $cont = 0;
        $group = array();
        foreach ($pend as $i => $value) {
            if ($i == 0) {
                $group = $value;
            }

            if ($i > 0) {
                if ($new[$i - 1]->responsible != $value->responsible) {
                    $cont++;
                    $group = $value;
                } else {
                    $group = $value;
                }
            }

            $arrpend[$cont][] = $group;
            $group = array();
        }


        $pay = DB::table("vdepartures")
                ->whereBetween("dispatched", array($init, $end))
                ->where("status_id", 7)
                ->orderBy("responsible")
                ->get();

        $arrpay = array();
        $cont = 0;
        $group = array();
        foreach ($pay as $i => $value) {
            if ($i == 0) {
                $group = $value;
            }

            if ($i > 0) {
                if ($new[$i - 1]->responsible != $value->responsible) {
                    $cont++;
                    $group = $value;
                } else {
                    $group = $value;
                }
            }

            $arrpay[$cont][] = $group;
            $group = array();
        }

        $emDetail = "";

        $email = Email::where("description", "overview")->first();

        if ($email != null) {
            $emDetail = EmailDetail::where("email_id", $email->id)->get();
        }

        if (count($emDetail) > 0) {
            $this->mails = array();

            foreach ($emDetail as $value) {
                $this->mails[] = $value->description;
            }

            $this->subject = "SuperFuds Cierre de ventas " . date("d/m");

            $header["date_report"] = $date_report;
            $header["arrnew"] = $arrnew;
            $header["arrpend"] = $arrpend;
            $header["arrpay"] = $arrpay;

            return view("Notifications.overview",$header);
//            Mail::send("Notifications.overview", $header, function($msj) {
//                $msj->subject($this->subject);
//                $msj->to($this->mails);
//            });
        }
    }

}
