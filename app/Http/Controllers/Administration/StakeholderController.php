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
use Datatables;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Uploads\Base;

class StakeholderController extends Controller {

    public $name;

    public function __construct() {
        $this->middleware("auth");
        $this->name = '';
    }

    public function index() {
        $type_person = Parameters::where("group", "typeperson")->get();
        $type_regimen = Parameters::where("group", "typeregimen")->get();
        $type_document = Parameters::where("group", "typedocument")->get();
        $type_stakeholder = Parameters::where("group", "typestakeholder")->get();
        return view("Administration.stakeholder.init", compact('type_person', "type_regimen", "type_document", "type_stakeholder"));
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);
            $input["status_id"] = 1;
            $result = Stakeholder::create($input);
            if ($result) {
                return response()->json(['success' => true]);
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
        return Datatables::eloquent(Branch::where("client_id", $in["client_id"])->orderBy("id", "asc"))->make(true);
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

    public function edit($id) {
        $resp["header"] = Stakeholder::FindOrFail($id);
        $resp["images"] = $this->getImages($id)->getData();
        return response()->json($resp);
    }

    public function update(Request $request, $id) {
        $stakeholder = Stakeholder::FindOrFail($id);
        $input = $request->all();
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

        $file->move("uploads/stakeholder/" . date("Y-m-d") . "/", $this->name);

//        if (is_file($this->path) === true) {
        Excel::load($this->path, function($reader) {
            $in["name"] = $this->name;
            $in["path"] = $this->path;
            $in["quantity"] = count($reader->get());
            $base_id = Base::create($in)->id;



            foreach ($reader->get() as $book) {

                if (stripos($book->nit_rut, "-") !== false) {
                    list($number, $verify) = explode("-", $book->nit_rut);
                } else {
                    $number = $book->nit_rut;
                }

                $stake = Stakeholder::where("document", $number)->first();

                $insert["lead_time"] = (int) $book->lead_time;
                $insert["document"] = $number;
                $insert["business"] = $book->nombre;
                $insert["business_name"] = $book->razon_social;
                $insert["email"] = $book->correo;
                $insert["web_site"] = $book->sitio_web;
                $insert["type_stakeholder"] = 2;
                $insert["term"] = $book->plazo;

                if (count($stake) > 0) {
                    if ((int) $stake->phone == '') {
                        $insert["phone_contact"] = (int) $book->celular;
                    }
                    if ($stake->contacto == '') {
                        $insert["contact"] = $book->contacto;
                    }

                    $stake->fill($insert)->save();
                } else {
                    $insert["phone_contact"] = (int) $book->celular;
                    $insert["contact"] = $book->contacto;
                    $insert["type_stakeholder"] = 2;
                    $insert["city_id"] = null;
                    $insert["status_id"] = 2;
                    $insert["type_document"] = null;
                    $insert["resposible_id"] = 1;
                    Stakeholder::create($insert);
                }
            }
        })->get();

        return response()->json(["success" => true]);
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
        $list = $this->getImages($in["stakeholder_id"]);
        return response()->json(["response" => true, "images" => $list]);
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

}
