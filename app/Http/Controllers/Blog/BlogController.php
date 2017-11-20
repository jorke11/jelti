<?php

namespace App\Http\Controllers\Blog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Administration\Characteristic;
use App\Models\Administration\Stakeholder;
use App\Models\Seller\Prospect;
use Mail;
use App\Models\Administration\Email;
use App\Models\Administration\EmailDetail;

class BlogController extends Controller {

    public $subject;
    public $emails;

    public function __construct() {
        $this->subject = '';
        $this->emails = [];
    }

    public function index() {
        $data = Blog\Content::paginate(10);
        return view("Blog.content.init", compact("data"));
    }

    public function getDetail($id) {
        $data = Blog\Content::find($id);
        return view("Blog.content.detail", compact("data"));
    }

    public function listProducts() {
        $products = \App\Models\Administration\Products::paginate();
        $subcategory = Characteristic::where("status_id", 1)->where("type_subcategory_id", 1)->orderBy("order", "asc")->get();

        return view("Blog.content.listproduct", compact("products", "subcategory"));
    }

    public function newVisitan(Request $req) {

        $in = $req->all();
//        print_r($in);
//        exit;
        unset($in["_token"]);
        $email = Stakeholder::where("email", $in["email"])->get();

        if (count($email) > 0) {
            return response()->json(["msg" => "Email ya esta registrado en nuestro sistema!", "status" => false], 500);
        }

        if ($in["type_stakeholder"] == 1) {
            $new = Prospect::create($in);
        } else {
            
        }

        unset($in["type_stakeholder"]);

        $this->mails[] = "jpinedom@hotmail.com";

        $email = Email::where("description", "page")->first();

        if ($email != null) {
            $emDetail = EmailDetail::where("email_id", $email->id)->get();

            if ($emDetail != null) {
                foreach ($emDetail as $value) {
                    $this->mails[] = $value->description;
                }
            }
        }
        $in["environment"] = env("APP_ENV");

        $this->subject = "Nuevo Registro";
        Mail::send("Notifications.prospect", $in, function($msj) {
            $msj->subject($this->subject);
            $msj->to($this->mails);
        });



        return response()->json(["msg" => "Creados!", "status" => true]);
    }

    public function emailCreate() {
        $name = "jorge";
        $last_name = "pinedo";
        $environment = "locaal";
        $created_at = date("Y-m-d");
        $business = "business";
        $email = "jppinedomasda@sdada.com";
        return view("Notifications.prospect", compact("name", "last_name", "environment", "created_at", "business", "email"));
    }

}
