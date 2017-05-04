<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Seller\Prospect;
use App\Models\Administration\Stakeholder;
use Session;

class ProspectsController extends Controller {

    public function __construct() {
        $this->middleware("auth");
    }

    public function index() {
        return view("Sellers.prospect.init");
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
