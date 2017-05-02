<?php

namespace App\Http\Controllers\Administration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration;
use App\Models\Core;
use Session;
use App\Models\Administration\Stakeholder;
use App\Models\Administration\StakeholderDocument;
use App\Models\Administration\PricesSpecial;
use App\Models\Administration\Branch;
use App\Models\Administration\Parameters;
use App\Models\Administration\Contact;
use App\Models\Administration\StakeholderTax;
use Datatables;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Uploads\Base;
use Auth;

class StakeholderController extends Controller {

    public $name;
    public $typestakeholder;
    public $updated;
    public $inserted;

    public function __construct() {
        $this->middleware("auth");
        $this->name = '';
        $this->updated = 0;
        $this->inserted = 0;
        $this->typestakeholder = 2;
    }

    public function index() {
        $type_person = Parameters::where("group", "typeperson")->get();
        $type_regimen = Parameters::where("group", "typeregimen")->get();
        $type_document = Parameters::where("group", "typedocument")->get();
        $type_stakeholder = Parameters::where("group", "typestakeholder")->get();
        $status = Parameters::where("group", "generic")->get();
        $tax = Parameters::where("group", "tax")->get();
        return view("Administration.stakeholder.init", compact('type_person', "type_regimen", "type_document", "type_stakeholder", "status", "tax"));
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);
            $input["user_insert"] = Auth::user()->id;
            $input["status_id"] = 1;
            $result = Stakeholder::create($input);
            if ($result) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false]);
            }
        }
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
        return Datatables::eloquent(PricesSpecial::where("client_id", $in["client_id"])->orderBy("id", "asc"))->make(true);
    }

    public function getBranch(Request $req) {
        $in = $req->all();
        return Datatables::eloquent(Branch::where("stakeholder_id", $in["client_id"])->orderBy("id", "asc"))->make(true);
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

    public function storeSpecial(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);

            $result = PricesSpecial::create($input);
            if ($result) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false]);
            }
        }
    }

    public function storeBranch(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);

            $result = Branch::create($input);
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
        $resp["header"] = Stakeholder::FindOrFail($id);
        $resp["images"] = $this->getImages($id)->getData();
        $resp["taxes"] = $this->getTax($id)->getData();
        return response()->json($resp);
    }

    public function update(Request $request, $id) {
        $stakeholder = Stakeholder::FindOrFail($id);
        $input = $request->all();
        $input["user_update"] = Auth::user()->id;
        $result = $stakeholder->fill($input)->save();
        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function destroy($id) {
        $stakeholder = Stakeholder::FindOrFail($id);
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
        $this->path = "uploads/stakeholder/" . date("Y-m-d") . "/" . $this->name;
        $this->typestakeholder = 2;
        $file->move("uploads/stakeholder/" . date("Y-m-d") . "/", $this->name);

//        if (is_file($this->path) === true) {
        Excel::load($this->path, function($reader) {
            $in["name"] = $this->name;
            $in["path"] = $this->path;
            $in["quantity"] = count($reader->get());
            $base_id = Base::create($in)->id;

            $verify = '';
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
                            $cont->fill($contact)->save();
                        } else {
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

        return response()->json(["success" => true, "data" => Stakeholder::where("status_id", 3)->get(), "updates" => $this->updated, "insert" => $this->inserted]);
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
//            $in["name"] = $this->name;
//            $in["path"] = $this->path;
//            $in["quantity"] = count($reader->get());
//            $base_id = Base::create($in)->id;

            $verify = '';
            foreach ($reader->get() as $book) {

//                dd($book);
                $number = $book->nit;
                $verify = $book->codigo_de_verificacion;



                $stake = Stakeholder::where("document", trim($number))->first();

                dd($stake);

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
                            $cont->fill($contact)->save();
                        } else {
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

        return response()->json(["success" => true, "data" => Stakeholder::where("status_id", 3)->get(), "updates" => $this->updated, "insert" => $this->inserted]);
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

    public function deleteBranch(Request $data, $id) {
        $image = Branch::find($id);
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
                ->select("stakeholder_tax.id", "parameters.description as tax","stakeholder_tax.stakeholder_id")
                ->join("parameters", "parameters.code", DB::raw("stakeholder_tax.tax_id and parameters.group='tax'"))
                ->where("stakeholder_id", $id)
                ->get();
        return response()->json($data);
    }

}
