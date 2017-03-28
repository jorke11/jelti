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
use Datatables;
use DB;

class StakeholderController extends Controller {

    public function __construct() {
        $this->middleware("auth");
    }

    public function index() {
        $type_person = Administration\TypePersons::all();
        $type_regimen = Administration\TypeRegimes::all();
        return view("Administration.stakeholder.init", compact('type_person', "type_regimen"));
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
        $resp["images"] = StakeholderDocument::where("stakeholder_id", $id)->get();
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
        $file = array_get($data, 'kartik-input-700');
        $name = $file[0]->getClientOriginalName();
//        dd($data);exit;
        $file[0]->move("images/stakeholder/" . $data["id"], $name);

        Administration\StakeholderDocument::where("stakeholder_id", $data["id"])->get();
        $stakeholder = new StakeholderDocument();
        $stakeholder->stakeholder_id = $data["id"];
        $stakeholder->document_id = $data["document_id"];
        $stakeholder->path = $data["id"] . "/" . $name;
        $stakeholder->save();
        return response()->json(["id" => $data["id"]]);
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
        $image = StakeholderDocument::find($id);
        $image->delete();
        StakeholderDocument::where("stakeholder_id", $data["stakeholder_id"]);
        return response()->json(["response" => true, "path" => $data->all()]);
    }

    public function deleteBranch(Request $data, $id) {
        $image = Branch::find($id);
        $image->delete();
        return response()->json(["success" => true]);
    }

    public function getImages($id) {
        $image = StakeholderDocument::where("stakeholder_id", $id)->get();
        return response()->json($image);
    }

}
