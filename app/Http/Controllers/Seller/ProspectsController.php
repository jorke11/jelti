<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Seller\Prospect;
use App\Models\Administration\Stakeholder;
use App\Models\Administration\Parameters;
use Session;
use Auth;

class ProspectsController extends Controller {

    public function __construct() {
        $this->middleware("auth");
    }

    public function index() {
        
         $type_person = Parameters::where("group", "typeperson")->get();
        $sector = Parameters::where("group", "sector")->get();
        $type_regimen = Parameters::where("group", "typeregimen")->get();
        $type_document = Parameters::where("group", "typedocument")->get();
        $type_stakeholder = Parameters::where("group", "typestakeholder")->get();
        $status = Parameters::where("group", "generic")->get();
        $tax = Parameters::where("group", "tax")->get();
        return view("Sellers.prospect.init", compact('type_person', "type_regimen", "type_document", "type_stakeholder", "status", "tax", "sector"));
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);
//            $user = Auth::User();
            $input["status_id"] = 1;
            $result = Prospect::create($input)->id;

            if ($result) {
                $data = Prospect::findOrFail($result);
                return response()->json(['success' => true, "header" => $data]);
            } else {
                return response()->json(['success' => false]);
            }
        }
    }

    public function edit($id) {
        $record = Prospect::FindOrFail($id);
        return response()->json($record);
    }

    public function update(Request $request, $id) {
        $record = Prospect::FindOrFail($id);
        $input = $request->all();
        $result = $record->fill($input)->save();
        if ($result) {

            $data = Prospect::FindOrFail($id);
            return response()->json(['success' => true, "data" => $data]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function destroy($id) {
        $record = Prospect::FindOrFail($id);
        $result = $record->delete();

        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function convertToClient(Request $req) {
        $in = $req->all();
        $record = Prospect::FindOrFail($in["id"]);

        $stake = array(
            'name' => $record->name,
            'last_name' => $record->last_name,
            'type_stakeholder' => 1,
            'city_id' => $record->city_id,
            'email' => $record->email,
            'address' => $record->address,
            'phone' => $record->phone,
            'bussines_name' => $record->bussines_name,
            'responsible_id' => $record->commercial_id,
            'web_site' => $record->web_site,
            'status_id' => 2,
            'user_insert' => Auth::user()->id,
            
        );

        $result = Stakeholder::create($stake);
        
        $record->status_id=2;
        $record->save();
        
        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

}
