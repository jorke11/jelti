<?php

namespace App\Http\Controllers\Sales;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Parameters;
use App\Models\Inventory\Departures;
use App\Models\Sales\BriefCase;
use DB;
use Datatables;
use Auth;
use App\Models\Security\Users;
use Mail;
use App\Models\Administration\Email;
use App\Models\Administration\EmailDetail;

class BriefcaseController extends Controller {

    public $name;
    public $path;

    public function __construct() {
        $this->middleware("auth");
        $this->name = '';
        $this->path = '';
    }

    public function index() {
        $category = \App\Models\Administration\Categories::all();
        $status = Parameters::where("group", "departure")->get();
        return view("Sales.Briefcase.init", compact("category", "status"));
    }

    public function getList(Request $req) {
        $in = $req->all();

        $query = DB::table("vbriefcase");

        if ($in["status_id"] == 0) {
            $query->whereNull("paid_out");
        } else if ($in["status_id"] == 1) {
            $query->whereNotNull("paid_out");
        }

        $query->orderBy("id", "asc");

        return Datatables::queryBuilder($query)->make(true);
    }

    public function getBriefcase(Request $req) {
        $input = $req->all();

        $resp = $this->formatDetail($input["departures"]);
        return response()->json(["success" => true, "data" => $resp]);
    }

    public function formatDetail($departures) {

        if (!is_array($departures) && strpos($departures, ",") !== false) {
            $departures = explode(",", $departures);
        }

        $dep = BriefCase::select("briefcase.id", "departures.invoice", "briefcase.value", "briefcase.created_at", DB::raw("briefcase.value::money as valuepayed"), "briefcase.img")
                ->join("departures", "departures.id", "briefcase.departure_id")
                ->orderBy("departures.invoice");

        if (is_array($departures)) {
            $dep->whereIn("briefcase.departure_id", $departures);
        } else {
            $dep->where("briefcase.departure_id", $departures);
        }

        $dep = $dep->get();
        $resp = array();
        $cont = 0;
        $total = 0;

        foreach ($dep as $i => $value) {
            if ($i > 0) {
                if ($dep[$i]->invoice != $dep[$i - 1]->invoice) {
                    $resp[$cont][] = array("total" => $total, "totalformated" => "$ " . number_format($total, 0, ",", "."));
                    $total = 0;
                    $cont++;
                }
            }
            $total += $value->value;
            $resp[$cont][] = array("id" => $value->id, "invoice" => $value->invoice, "value" => $value->value, "created_at" => date("Y-m-d H:i", strtotime($value->created_at))
                , "valuepayed" => $value->valuepayed, "img" => $value->img);
            if ($i == (count($dep) - 1)) {
                $resp[$cont][] = array("total" => $total, "totalformated" => "$ " . number_format($total, 0, ",", "."));
            }
        }

        return $resp;
    }

    public function storePayment(Request $req) {
        $input = $req->all();
        $departures = $input["invoices"];
        $values = $input["values"];

        try {
            DB::beginTransaction();

            $this->name = '';
            $this->path = '';
            $file = array_get($input, 'document_file');

            if ($file) {
                $this->name = $file->getClientOriginalName();
                $this->name = str_replace(" ", "_", $this->name);
                $this->path = "uploads/invoice/" . date("Y-m-d") . "/" . $this->name;
                $file->move("uploads/invoice/" . date("Y-m-d") . "/", $this->name);
            }
            $emDetail = null;
            $newin = array();

            foreach ($departures as $i => $value) {
                $new["departure_id"] = $value;
                $new["value"] = $values[$i];
                if ($file) {
                    $new["img"] = $this->path;
                }
                $newin[] = BriefCase::create($new)->id;
            }


            $email = Email::where("description", "deposit")->first();

            if ($email != null) {
                $emDetail = EmailDetail::where("email_id", $email->id)->get();
            }

            if (count($emDetail) > 0) {
                $this->mails = array();

                foreach ($emDetail as $value) {
                    $this->mails[] = $value->description;
                }

                $detail = BriefCase::whereIn("briefcase.id", $newin)
                        ->join("vdepartures", "vdepartures.id", "departure_id")
                        ->get();
                $subtotal = 0;
                foreach ($detail as $value) {
                    $subtotal += $value["value"];
                }
                $header["subtotal"] = number_format($subtotal, 0, ".", ",");

                $header["client"] = $detail[0]->client;
                $header["responsible"] = $detail[0]->responsible;

                $this->subject = "SuperFuds " . date("d/m") . " Abono cartera " . $detail[0]->client;

                $header["detail"] = $detail;
                $header["environment"] = env("APP_ENV");

                $user = Users::find($detail[0]->responsible_id);

                $this->mails[] = $user->email;

                if ($header["environment"] == 'local') {
                    $this->mails = Auth::User()->email;
                }

                Mail::send("Notifications.deposit", $header, function($msj) {
                    $msj->subject($this->subject);
                    $msj->to($this->mails);
                });
            }

            $response = $this->formatDetail($departures);
            DB::commit();
            return response()->json(["success" => true, "data" => $response]);
        } catch (Exception $exp) {
            DB::rollback();
            return response()->json(["success" => false, "msg" => "Problemas con la ejecución"], 401);
        }
    }

    public function testNotification($departure_id) {
        $detail = BriefCase::whereIn("briefcase.id", array(162, 163))
                ->join("vdepartures", "vdepartures.id", "departure_id")
                ->get();
        $subtotal = 0;
        foreach ($detail as $value) {
            $subtotal += $value["value"];
        }
        $subtotal = number_format($subtotal, 0, ".", ",");

        $client = $detail[0]->client;
        $responsible = $detail[0]->responsible;
        $environment = "production";

        return view("Notifications.deposit", compact("responsible", "client", "environment", "detail", "subtotal"));
    }

    public function delete(Request $req, $id) {
        $in = $req->all();
        $departures = $in["departures"];
        $brief = BriefCase::find($id);
        $brief->delete();
        $resp = $this->formatDetail($departures);

        return response()->json(["success" => true, "data" => $resp]);
    }

    public function edit($id) {
        return $this->formatDetail($id);
    }

    public function payInvoice(Request $req, $id) {
        $in = $req->all();
        try {
            DB::beginTransaction();
            $row = Departures::find($id);
            $row->paid_out = true;
            $row->description = "Pagado: " . $in["description"] . ", " . $row->description;
            $row->outstanding = $in["saldo"];
            $row->update_id = Auth::user()->id;
            $row->status_id = 7;
            $row->save();



            $email = Email::where("description", "payments")->first();

            if ($email != null) {
                $emDetail = EmailDetail::where("email_id", $email->id)->get();
            }

            if (count($emDetail) > 0) {
                $this->mails = array();


                $row = DB::table("vdepartures")->where("id", $id)->first();

                $header["invoice"] = $row->invoice;
                $header["total"] = number_format($row->total, 0, ".", ",");
                $header["client"] = $row->client;
                $header["responsible"] = $row->responsible;
                $header["description"] = $row->description;
                

                $this->subject = "SuperFuds " . date("d/m") . " Pago cartera " . $row->client;

                $header["environment"] = env("APP_ENV");

                $user = Users::find($row->responsible_id);

                $this->mails[] = $user->email;

                if ($header["environment"] == 'local') {
                    $this->mails = Auth::User()->email;
                }

                Mail::send("Notifications.paidout", $header, function($msj) {
                    $msj->subject($this->subject);
                    $msj->to($this->mails);
                });
            }

            DB::commit();
            return response()->json(["success" => true, "data" => $row]);
        } catch (Exception $exp) {
            DB::rollback();
            return response()->json(["success" => false, "msg" => "Problemas con la ejecución"], 401);
        }
    }

    public function testPaidout($id) {

        $row = DB::table("vdepartures")->where("invoice", $id)->first();

        $invoice = $row->invoice;
        $description = $row->description;
        $total = number_format($row->total, 0, ".", ",");

        $client = $row->client;
        $responsible = $row->responsible;
        $environment = "production";

        return view("Notifications.paidout", compact("responsible", "client", "environment", "total", "invoice", "description"));
    }

}
