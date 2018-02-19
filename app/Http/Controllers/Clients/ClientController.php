<?php

namespace App\Http\Controllers\Clients;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Parameters;
use App\Models\Administration\Stakeholder;
use App\Models\Administration\Contact;
use App\Models\Administration\PricesSpecial;
use App\Models\Administration\Comment;
use Auth;
use DB;
use Datatables;
use App\Models\Administration\Branch;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Administration\Products;
use App\Models\Security\Users;

class ClientController extends Controller {

    public $name;
    public $in;
    public $typestakeholder;
    public $updated;
    public $updatedCont;
    public $inserted;
    public $insertedCont;
    public $countData;
    public $base_id;

    public function __construct() {
        $this->middleware("auth");
        $this->name = '';
        $this->updated = 0;
        $this->updatedCont = 0;
        $this->inserted = 0;
        $this->insertedCont = 0;
        $this->countData = 0;
        $this->typestakeholder = 2;
        $this->base_id = 0;
    }

    public function index() {
        $type_person = Parameters::where("group", "typeperson")->get();
        $sector = Parameters::where("group", "sector")->get();
        $type_regimen = Parameters::where("group", "typeregimen")->get();
        $type_document = Parameters::where("group", "typedocument")->get();
        $type_stakeholder = Parameters::where("group", "typestakeholder")->get();
        $status = Parameters::where("group", "generic")->get();
        $tax = Parameters::where("group", "tax")->get();
        return view("Clients.client.init", compact('type_person', "type_regimen", "type_document", "type_stakeholder", "status", "tax", "sector"));
    }

    public function store(Request $request) {
        $type = 0;
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);

            $input["user_insert"] = Auth::user()->id;
            $input["status_id"] = 1;
            $input["type_stakeholder"] = 1;
            $input["shipping_cost"] = isset($input["shipping_cost"]) ? true : false;
            $input["special_price"] = isset($input["special_price"]) ? true : false;
            $input["login_web"] = isset($input["login_web"]) ? true : false;
            $input["exclude_report"] = (isset($input["exclude_report"])) ? 1 : 0;
            
            $input["document"] = trim($input["document"]);
            $input["email"] = trim($input["email"]);

            try {
                DB::beginTransaction();
                $document = Stakeholder::where("document", $input["document"])->first();

                if (isset($input["stakeholder_id"])) {
                    $type = 1;
                    $result = Branch::create($input);
                } else {
                    if ($document == null) {
                        $type = 2;
                        $result = Stakeholder::create($input);
                    } else {
                        DB::rollback();
                        return response()->json(['success' => false, "msg" => "Cliente ya existe"], 409);
                    }
                }

                if ($result) {
                    DB::commit();
                    return response()->json(['success' => true, "header" => $result]);
                } else {
                    return response()->json(['success' => false, "msg" => "Problemas con la ejecución"], 409);
                }
            } catch (Exception $exc) {
                DB::rollback();
                return response()->json(['success' => false, "msg" => "Wrong"], 409);
            }
        }
    }

    public function getBranch($id) {
        $response = DB::table("vbranch_office")->where("stakeholder_id", $id)->get();
        return response()->json(["response" => $response]);
    }

    public function getBranchId($id) {
        $response = Branch::select("branch_office.id", "stakeholder.type_person_id", "stakeholder.type_regime_id", "branch_office.responsible_id", "stakeholder.type_document", "branch_office.document", "branch_office.verification", "branch_office.business", "branch_office.business_name", "stakeholder.sector_id", "branch_office.city_id", "branch_office.term", "branch_office.stakeholder_id", "branch_office.email", "branch_office.web_site", "branch_office.send_city_id", "branch_office.invoice_city_id", "branch_office.address_send", "branch_office.address_invoice")
                        ->join("stakeholder", "stakeholder.id", "branch_office.stakeholder_id")
                        ->where("branch_office.id", $id)->first();
        return response()->json(["response" => $response]);
    }

    public function getSpecialId($id) {
        $response = PricesSpecial::find($id);
        return response()->json(["response" => $response]);
    }

    public function storeTax(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);

            $result = StakeholderTax::create($input);
            if ($result) {
                $resp = $this->getTax($input["stakeholder_id"])->getData();
                return response()->json(['success' => true, "detail" => $resp]);
            } else {
                return response()->json(['success' => false]);
            }
        }
    }

    public function getSpecial(Request $req) {
        $in = $req->all();
        $sql = DB::table("vprice_special")
                        ->where("client_id", $in["client_id"])->orderBy("id", "asc");

        return Datatables::queryBuilder($sql)->make(true);
    }

    public function getContact(Request $req) {
        $in = $req->all();
        $query = DB::table("vcontacts")
                ->where("stakeholder_id", $in["stakeholder_id"])
                ->orderBy("id", "asc");

        return Datatables::queryBuilder($query)->make(true);
    }

    public function updatePrice(Request $data, $id) {
        $input = $data->all();
        if ($input["id"] != '') {
            PricesSpecial::where("client_id", $id)->update(['priority' => false]);
            PricesSpecial::where("id", $input["id"])->update(['priority' => true]);
        } else {
            PricesSpecial::where("client_id", $id)->update(['priority' => false]);
        }

        return response()->json(["success" => true]);
    }

    public function updatePriceId(Request $data, $id) {
        $input = $data->all();
        unset($input["id"]);
        $price = PricesSpecial::find($id);
        if ($input["item"] == '') {
            unset($input["item"]);
        }

        $input["packaging"] = ($input["packaging"] == '') ? 1 : $input["packaging"];
        $input["units_sf"] = (int) $input["units_sf"];
        $price->fill($input)->save();

        return response()->json(["success" => true]);
    }

    public function updateContact(Request $data, $id) {
        $input = $data->all();
        unset($input["id"]);
        $contact = Contact::find($id);
        $contact->fill($input)->save();
        return response()->json(["success" => true]);
    }

    public function storeSpecial(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);

            $special = PricesSpecial::where("product_id", $input["product_id"])->where("client_id", $input["client_id"])->first();

            if ($special == null) {
                $input["packaging"] = ($input["packaging"] == null) ? 1 : $input["packaging"];
                $input["item"] = ($input["item"] == null) ? null : $input["item"];
                $result = PricesSpecial::create($input);
                if ($result) {
                    return response()->json(['success' => true]);
                } else {
                    return response()->json(['success' => false, "msg" => "Problemas con la solicitud"], 409);
                }
            } else {
                return response()->json(['success' => false, "msg" => "Producto ya existe"], 409);
            }
        }
    }

    public function storeContact(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);
            $input["user_insert"] = Auth::user()->id;
            $input["status_id"] = 1;
            $result = Contact::create($input);
            if ($result) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false]);
            }
        }
    }

    public function addChanges(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);

            $stake = Stakeholder::findOrFail($input["stakeholder_id"]);
            $stake->status_id = $input["status_id"];
            $stake->save();

            return response()->json(['success' => true, "data" => $stake]);
        }
    }

    public function edit($id) {


        $comment = Comment::select("comments.id", "comments.description", "users.name", "comments.created_at")
                ->join("users", "users.id", "comments.user_id")
                ->where("comments.stakeholder_id", $id)
                ->orderBy("comments.created_at", "desc")
                ->get();

        $resp["header"] = Stakeholder::Find($id);
//        $resp["images"] = $this->getImages($id)->getData();
        $resp["comments"] = $comment;
        return response()->json($resp);
    }

    public function editContact($id) {
        $resp = Contact::Find($id);
        return response()->json($resp);
    }

    public function update(Request $request, $id) {
        $input = $request->all();

        $input["shipping_cost"] = isset($input["shipping_cost"]) ? true : false;
        $input["special_price"] = isset($input["special_price"]) ? true : false;
        $input["login_web"] = (isset($input["login_web"])) ? 1 : 0;
        $input["exclude_report"] = (isset($input["exclude_report"])) ? 1 : 0;

        if (isset($input["login_web"])) {
            $input["login_web"] = 1;
            $user = Users::where("email", $input["email"])->first();
        } else {
            $input["login_web"] = 0;
        }


        if (!isset($input["stakeholder_id"])) {

            $input["stakeholder_id"] = null;
            $stakeholder = Stakeholder::Find($id);
        } else {

            $stakeholder = Branch::Find($id);
        }

        $input["address_send"] = trim($input["address_send"]);
        $input["address_invoice"] = trim($input["address_invoice"]);
        $input["web_site"] = trim($input["web_site"]);
        $input["email"] = trim($input["email"]);
        $input["business"] = trim($input["business"]);
        $input["business_name"] = trim($input["business_name"]);
        $input["shipping_cost"] = (isset($input["shipping_cost"])) ? 1 : 0;
        $input["price_special"] = (isset($input["price_special"])) ? 1 : 0;
        $input["user_update"] = Auth::user()->id;
        $input["status_id"] = 1;

        if ($stakeholder == null) {

            $result = Stakeholder::create($input);
        } else {

            if ($input["password"] != '') {
                $input["password"] = bcrypt($input["password"]);

                if ($stakeholder->password == $input["password"]) {
                    unset($input["password"]);
                }
            }

            $result = $stakeholder->fill($input)->save();
        }

        $new["name"] = $input["business"];
        $new["email"] = $input["email"];
        $new["document"] = $input["document"];
        $new["password"] = $input["password"];
        $new["status_id"] = $input["status_id"];
        $new["role_id"] = 2;

        if ($user == null) {
            Users::create($new);
        } else {
            $users = Users::find($user->id);
            $users->fill($new)->save();
        }

        if ($result) {
            return response()->json(['success' => true, "header" => $result]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function destroy($id) {
        $stakeholder = Stakeholder::FindOrFail($id);
        $result = $stakeholder->delete();
//        $stakeholder->status_id = 4;
//        $result = $stakeholder->save();
//        $result = $stakeholder->delete();
        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function destroyPrice($id) {
        $row = PricesSpecial::find($id);
        $result = $row->delete();

        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function destroyBranch($id) {
        $stakeholder = Branch::FindOrFail($id);
        $result = $stakeholder->delete();

        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function uploadImage(Request $req) {
        $data = $req->all();

        $file = array_get($data, 'document_file');

//        $name = $file[0]->getClientOriginalName();
        $name = $file->getClientOriginalName();
//        $file[0]->move("images/stakeholder/" . $data["stakeholder_id"], $name);
        $file->move("images/stakeholder/" . $data["stakeholder_id"], $name);

        Administration\StakeholderDocument::where("stakeholder_id", $data["stakeholder_id"])->get();
        $stakeholder = new StakeholderDocument();
        $stakeholder->stakeholder_id = $data["stakeholder_id"];
        $stakeholder->document_id = $data["document_id"];
        $stakeholder->path = $data["stakeholder_id"] . "/" . $name;
        $stakeholder->name = $name;
        $stakeholder->save();
        return $this->getImages($data["stakeholder_id"]);
    }

    public function uploadExcel(Request $req) {
        $data = $req->all();

        $file = array_get($data, 'file_excel');

        $this->name = $file->getClientOriginalName();
        $this->name = str_replace(" ", "_", $this->name);
        $this->path = "uploads/clients/" . date("Y-m-d") . "/" . $this->name;
        $this->typestakeholder = 2;
        $file->move("uploads/clients/" . date("Y-m-d") . "/", $this->name);

//        if (is_file($this->path) === true) {
        Excel::load($this->path, function($reader) {
            $in["name"] = $this->name;
            $in["path"] = $this->path;
            $in["quantity"] = count($reader->get());
            $base_id = Base::create($in)->id;

            $verify = '';
            $this->countData = count($reader->get());
            foreach ($reader->get() as $book) {

                if (stripos($book->nit_rut, "-") !== false) {
                    list($number, $verify) = explode("-", $book->nit_rut);
                } else {
                    $number = trim($book->nit_rut);
                }

                $stake = Stakeholder::where("document", trim($number))->first();

                if ($verify != '') {
                    $insert["verification"] = $verify;
                }

                $city = Administration\Cities::where("description", "ILIKE", "%" . $book->ciudad . "%")->first();
                if (count($city) > 0) {
                    $insert["city_id"] = $city->id;
                } else {
                    $insert["city_id"] = null;
                }

                $insert["user_insert"] = Auth::user()->id;
                $insert["status_id"] = 3;
                $insert["lead_time"] = (int) trim($book->lead_time);
                $insert["document"] = trim($number);
                $insert["business"] = trim($book->nombre);
                $insert["business_name"] = trim($book->razon_social);
                $insert["email"] = trim($book->correo);
                $insert["web_site"] = trim($book->sitio_web);
                $insert["type_stakeholder"] = $this->typestakeholder;
                $insert["term"] = (trim($book->plazo)) == '' ? 0 : trim($book->plazo);
                $insert["phone"] = (int) trim($book->celular);
                $insert["name"] = trim($book->contact);

                if (count($stake) > 0) {

                    if ($stake->phone != $book->celular) {
                        $cont = Contact::where("phone", $book->celular)->first();
                        $contact["stakeholder_id"] = $stake->id;
                        $contact["city_id"] = $insert["city_id"];
                        $contact["name"] = trim($book->contacto);
                        $contact["email"] = trim($book->correo);
                        $contact["mobile"] = trim($book->celular);
                        $contact["web_site"] = trim($book->sitio_web);

                        if (count($cont) > 0) {
                            $this->updatedCont++;
                            $cont->fill($contact)->save();
                        } else {
                            $this->insertedCont++;
                            Contact::create($contact);
                        }
                    } else {
                        $stake->fill($insert)->save();
                        $this->updated++;
                    }
                } else {

                    $insert["phone_contact"] = (int) trim($book->celular);
                    $insert["contact"] = trim($book->contacto);
                    $insert["type_stakeholder"] = 2;
                    $insert["type_document"] = null;
                    $insert["resposible_id"] = 1;

                    Stakeholder::create($insert);
                    $this->inserted++;
                }
            }
        })->get();

        return response()->json(["success" => true, "data" => Stakeholder::where("status_id", 3)->get(), "updated" => $this->updated
                    , "inserted" => $this->inserted, "quantity" => $this->countData, "contactnew" => $this->insertedCont, "contactedit" => $this->updatedCont]);
    }

    public function uploadClient(Request $req) {
        $data = $req->all();

        $file = array_get($data, 'file_excel');

        $this->name = $file->getClientOriginalName();
        $this->name = str_replace(" ", "_", $this->name);
        $this->path = "uploads/stakeholder/" . date("Y-m-d") . "/" . $this->name;
        $this->typestakeholder = 2;
        $file->move("uploads/stakeholder/" . date("Y-m-d") . "/", $this->name);

//        if (is_file($this->path) === true) {
        Excel::load($this->path, function($reader) {
            $in["name"] = $this->name;
            $in["path"] = $this->path;
            $in["quantity"] = count($reader->get());
            $this->base_id = Base::create($in)->id;

            $verify = '';
            foreach ($reader->get() as $book) {

                $number = $book->nit;
                $verify = $book->codigo_de_verificacion;

                $new["user_insert"] = Auth::user()->id;
                $new["type_stakeholder"] = 1;
                $new["status_id"] = 3;
                $new["responsible_id"] = 1;
                $new["business"] = trim($book->cuenta_principal);
                $new["phone"] = trim($book->telefono);
                $new["web_site"] = trim($book->sitio_web);
                $new["document"] = (int) trim($book->nit);
                $new["verification"] = (int) trim($book->codigo_de_verificacion);
                $new["business_name"] = $this->cleanText(trim($book->razon_social));
                $new["term"] = (int) trim($book->plazo_de_pago_dias);
                $new["email"] = trim($book->correo_electronico);
                $book->cuenta_principal = $this->cleanText($book->cuenta_principal);

                $business = Stakeholder::where("business", "ILIKE", "%" . trim($book->cuenta_principal) . "%")->first();

                if ($business == null) {
                    $stakeholder_id = Stakeholder::create($new)->id;
                } else {
                    $business->fill($new)->save();
                    $stakeholder_id = $business->id;
                }


                if (strpos($book->celular, "-") !== false) {
                    $cel = explode("-", $book->celular);
                    $book->celular = trim($cel[0]);
                }
                if (strpos($book->celular, "/") !== false) {
                    $cel = explode("/", $book->celular);
                    $book->celular = trim($cel[0]);
                }


                $branch = Branch::where("document", trim($number))->where("mobile", $book->celular)->first();

                if ($this->cleanText($book->ciudad_de_envio) != 'N/A') {
                    $ciudad_de_envio = Administration\Cities::where("description", "ILIKE", "%" . $this->cleanText($book->ciudad_de_envio) . "%")->first();
                    $ciudad_de_envio = ($ciudad_de_envio == null) ? null : $ciudad_de_envio->id;
                } else {
                    $ciudad_de_envio = null;
                }

                if ($this->cleanText($book->ciudad_de_facturacion) != 'N/A') {
                    $ciudad_de_facturacion = Administration\Cities::where("description", "ILIKE", "%" . $this->cleanText($book->ciudad_de_facturacion) . "%")->first();
                    $ciudad_de_facturacion = ($ciudad_de_facturacion == null) ? null : $ciudad_de_facturacion->id;
                } else {
                    $ciudad_de_envio = null;
                }

                $new["invoice_city_id"] = $ciudad_de_facturacion;
                $new["send_city_id"] = $ciudad_de_envio;
                $new["stakeholder_id"] = $stakeholder_id;
                $new["address_invoice"] = $book->domicilio_de_facturacion;
                $new["address_send"] = $book->domicilio_de_envio;

                if ($new["business_name"] != '') {
                    if ($ciudad_de_facturacion != null) {

                        $new["city_id"] = $ciudad_de_facturacion;
                        unset($new["type_stakeholder"]);

                        if ($branch == null) {
                            Branch::create($new);
                        } else {
                            $branch->fill($new)->save();
                        }
                    } else {
                        $error["base_id"] = $this->base_id;
                        $error["reason"] = "No existe ciudad facturación: " . $book->ciudad_de_facturacion;
                        $error["data"] = json_encode($book);
                        FileErrors::create($error);
                    }
                } else {
                    $error["base_id"] = $this->base_id;
                    $error["reason"] = "Razon social vacia: " . $new["business_name"];
                    $error["data"] = json_encode($book);
                    FileErrors::create($error);
                }
            }
        })->get();

        return response()->json(["success" => true, "data" => FileErrors::where("base_id", $this->base_id)->get(), "updates" => $this->updated, "insert" => $this->inserted]);
    }

    function cleanText($string) {
        $string = trim($string);
        $string = utf8_encode((filter_var($string, FILTER_SANITIZE_STRING)));
        $string = str_replace(
                array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä', 'Ã'), array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A', 'A'), $string
        );
        $string = str_replace(
                array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'), array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'), $string
        );
        $string = str_replace(
                array('í', 'ì', 'ï', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'), array('i', 'i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'), $string
        );
        $string = str_replace(
                array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'), array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'), $string
        );
        $string = str_replace(
                array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'), array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'), $string
        );
        $string = str_replace(
                array('ñ', 'Ñ', 'ç', 'Ç'), array('n', 'N', 'c', 'C'), $string
        );
        $string = str_replace(
                array("\\", "¨", "º", "–", "~", "|", "·",
            "¡", "[", "^", "`", "]", "¨", "´", "¿",
            '§', '¤', '¥', 'Ð', 'Þ'), '', $string
        );
        $string = str_replace(
                array(";",), array(","), $string
        );
        $string = str_replace(
                array("&#39;", "&#39,", '&#34;', '&#34,'), array("'", "'", '"', '"'), $string
        );
        $string = htmlentities($string, ENT_QUOTES | ENT_IGNORE, 'UTF-8');

        $string = str_replace(
                array('&quot;', '&#39;', '&#039;'), array('"', "'", "'"), $string
        );
        $string = str_replace(
                array('&amp;', '&nbsp;'), array('&', ' '), $string
        );
        $string = str_replace(
                array('&deg;', '&sup3;', '&shy;'), array(''), $string
        );
        $string = str_replace(
                array('&copy;', '&sup3;', '&shy;', '&plusmn;'), array('e', 'o', 'i', 'n'), $string
        );
        return $string;
    }

    public function checkmain(Request $data, $id) {
        $input = $data->all();
        $stakeholder = Stakeholder::find($input["id"]);

        DB::table("stakeholder_document")->where("stakeholder_id", $input["id"])->update(['main' => false]);
        $image = Administration\StakeholderDocument::where("id", $id)->update(['main' => true]);
        $image = Administration\StakeholderDocument::find($id);
        $stakeholder->image = $image->path;
        $stakeholder->save();
        return response()->json(["response" => true, "path" => $image]);
    }

    public function deleteImage(Request $data, $id) {
        $in = $data->all();
        $image = StakeholderDocument::find($id);
        $image->delete();
        $list = $this->getImages($in["stakeholder_id"])->getData();
        return response()->json(["response" => true, "images" => $list]);
    }

    public function deleteTax(Request $data, $id) {
        $in = $data->all();
        $image = StakeholderTax::find($id);
        $image->delete();
        $list = $this->getTax($in["stakeholder_id"])->getData();
        return response()->json(["success" => true, "detail" => $list]);
    }

    public function deleteContact(Request $data, $id) {
        $image = Contact::find($id);
        $image->delete();
        return response()->json(["success" => true]);
    }

    public function getImages($id) {
        $image = DB::table("stakeholder_document")
                        ->select("stakeholder_document.id", "stakeholder_document.stakeholder_id", "stakeholder_document.document_id", "parameters.description as document", "stakeholder_document.path", "stakeholder_document.name")
                        ->join("parameters", "parameters.code", DB::raw("stakeholder_document.document_id and parameters.group='typedocument'"))
                        ->where("stakeholder_id", $id)->get();
        return response()->json($image);
    }

    public function getTax($id) {
        $data = DB::table("stakeholder_tax")
                ->select("stakeholder_tax.id", "parameters.description as tax", "stakeholder_tax.stakeholder_id")
                ->join("parameters", "parameters.code", DB::raw("stakeholder_tax.tax_id and parameters.group='tax'"))
                ->where("stakeholder_id", $id)
                ->get();
        return response()->json($data);
    }

    public function storeComment(Request $request) {
        $in = $request->all();
        $new["description"] = $in["comment"];
        $new["stakeholder_id"] = $in["client_id"];
        $new["user_id"] = Auth::user()->id;
        Comment::create($new);
        $comment = Comment::select("comments.id", "comments.description", "users.name", "comments.created_at")
                ->join("users", "users.id", "comments.user_id")
                ->where("comments.stakeholder_id", $in["client_id"])
                ->orderBy("comments.created_at", "desc")
                ->get();

        return response()->json(["success" => true, "detail" => $comment]);
    }

    public function storeExcelCode(Request $request) {
        if ($request->ajax()) {
            $this->in = $request->all();
            $this->name = '';
            $this->path = '';
            $file = array_get($this->in, 'file_excel');
            $this->name = $file->getClientOriginalName();
            $this->name = str_replace(" ", "_", $this->name);
            $this->path = "uploads/prices/" . date("Y-m-d") . "/" . $this->name;

            $file->move("uploads/prices/" . date("Y-m-d") . "/", $this->name);
            $error = array();
            Excel::load($this->path, function($reader) {

                foreach ($reader->get() as $book) {
                    $product = '';
                    $item = null;
                    $price = null;
                    if ($book->price_sf != '') {
                        if ($book->item != '') {

                            if (trim($book->sf_code) != '') {
                                $product = Products::where("reference", trim($book->sf_code))->first();
                            } else {
                                if (trim($book->ean) != '') {
                                    $product = Products::where("bar_code", trim($book->ean))->first();
                                }
                            }
                            $item = $book->item;
                        } else if ($book->ean != '') {
                            $product = Products::where("bar_code", trim($book->ean))->first();
                        } else if ($book->sf_code != '') {
                            $product = Products::where("reference", trim($book->sf_code))->first();
                        }


                        if ($product != '') {
                            if ($item != '') {
                                $price = PricesSpecial::where("item", $item)->first();
                            }

                            $new["client_id"] = $this->in["client_id"];
                            $new["product_id"] = $product->id;
                            $new["price_sf"] = round($book->price_sf);
                            $new["packaging"] = $book->packaging;
                            $new["margin"] = 1;
                            $new["units_sf"] = (int) $product->units_sf;
                            $new["margin_sf"] = 1;
                            $new["item"] = $item;
                            $new["tax"] = $product->tax;

                            if ($price == null) {
                                $this->inserted++;
                                PricesSpecial::create($new);
                            } else {
                                $this->updated++;
                                $p = PricesSpecial::find($price->id);
                                $p->fill($new)->save();
                            }
                        }
                    } else {
                        $error[] = array("data" => $book, "error" => "Price Empty");
                    }
                }
            })->get();

            $detail = PricesSpecial::select("prices_special.item", "prices_special.tax", "prices_special.price_sf", "products.bar_code", "products.reference", "products.title")
                    ->join("products", "products.id", "prices_special.product_id")
                    ->where("prices_special.client_id", $this->in["client_id"])
                    ->get();

            return response()->json(["success" => true, "data" => $detail,
                        "updated" => $this->updated, "inserted" => $this->inserted, "error" => $error]);
        }
    }

}
