<?php

namespace App\Http\Controllers\Blog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Blog\Post;
use App\Models\Administration\Characteristic;
use App\Models\Administration\Stakeholder;
use App\Models\Seller\Prospect;
use Mail;
use App\Models\Administration\Email;
use App\Models\Administration\EmailDetail;
use Auth;
use Image;
use File;
use Illuminate\Support\Facades\Input;
use DB;
use App\Models\Security\Users;

class BlogController extends Controller {

    public $subject;
    public $emails;

    public function __construct() {
        $this->subject = '';
        $this->emails = [];
        
    }

    public function index() {
        $last = Post::orderBy("created_at", "desc")->first();
        $data = Post::where("id", "<>", $last->id)->paginate(10);
//        dd($data);
        return view("Blog.content.init", compact("data", "last"));
    }

    public function getDetail($slug) {
        $data = Post::findBySlug($slug);
        $products = DB::table("vproducts")->whereNotNull("image")->whereNotNull("warehouse")->get();
        $writer = Users::find($data->user_id);
        $comments = Blog\Feedback::where("row_id", $data->id)->orderBy("created_at", "desc")->get();

//        dd($comment);exit;
        return view("Blog.content.detail", compact("data", "products", "comments", "writer"));
    }

    public function getAllPost() {
        $data = Post::paginate(10);
        return view("Blog.admin.init", compact("data"));
    }

    public function show($id) {
        $row = Post::find($id);
        return view("Blog.admin.edit", compact("row"));
    }

    public function create() {
        $row = array();
        return view("Blog.admin.new", compact("row"));
    }
    

    public function newComment(Request $req) {
        $in = $req->all();
//        dd($in);
        $new["title"] = $in["title"];
        $new["content"] = $in["comment"];
        $new["email"] = $in["email"];
        $new["name"] = $in["name"];
        $new["type_id"] = 1;
        $new["row_id"] = $in["id"];

        $res = Blog\Feedback::create($new);
//        dd($res);

        $data = Post::find($in["id"]);
        $comments = Blog\Feedback::where("row_id", $in["id"])->orderBy("created_at", "desc")->get();
        $products = DB::table("vproducts")->whereNotNull("image")->whereNotNull("warehouse")->get();

//        dd($commmets);
        return view("Blog.content.detail", compact("data", "products", "comments"));
    }

    public function store(Request $req) {
        $in = $req->all();
        $in["user_id"] = Auth::user()->id;

        $file = Input::file('img');

        unset($in["id"]);
        $res = Post::create($in);

        if ($file != null) {
            $image = Image::make(Input::file('img'));
            $path = public_path() . '/uploads/blog/' . $res->id . "/";
            $paththumb = public_path() . '/uploads/blog/' . $res->id . "/thumbmail/";

            File::makeDirectory($path, $mode = 0777, true, true);
            File::makeDirectory($paththumb, $mode = 0777, true, true);

            $row = Post::find($res->id);

            $row->img = 'uploads/blog/' . $res->id . '/' . $file->getClientOriginalName();
            $image->save($path . $file->getClientOriginalName())->widen(800);

            $image->resize(400, 250);
            $row->thumbnail = 'uploads/blog/' . $res->id . '/thumbmail/' . $file->getClientOriginalName();
            $image->save($paththumb . $file->getClientOriginalName());
            $row->save();
        }

        return redirect()->route("admin.blog");
    }

    public function update(Request $req, $id) {
        $in = $req->all();
        unset($in["img"]);
        $row = Post::find($id);
        $row->fill($in);
        $row->save();
        return redirect()->route("admin.blog");
    }

    public function delete($id) {
        $row = Post::find($id);
        return view("Blog.admin.delete", compact("row"));
    }

    public function destroy(Request $req) {
        $in = $req->all();
        $row = Post::find($in["id"]);
        $row->delete();
        return redirect()->route("admin.blog");
    }

    public function delete2(Request $req, $id) {
        return redirect()->route("admin.blog");
    }

    public function updatePost(Request $req, $id) {
        dd($req->all());
    }

    public function listProducts() {
        $products = DB::table("vproducts")->where("status_id", "<>", 1)->paginate(10);
        $subcategory = Characteristic::where("status_id", 1)->where("type_subcategory_id", 1)->orderBy("order", "asc")->get();

        return view("Blog.content.listproduct", compact("products", "subcategory"));
    }

    public function newVisitan(Request $req) {

        $in = $req->all();

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
