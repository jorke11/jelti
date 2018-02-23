<?php

namespace App\Http\Controllers\Crm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Seller\Activity;

class ActivityController extends Controller {

    public function __construct() {
        $this->middleware("auth");
    }

    public function index() {
        return view("crm.activity.init");
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);
//            $user = Auth::User();
//            $input["users_id"] = 1;
            $input["status_id"] = 1;

            $result = Activity::create($input)->id;
            if ($result) {
                $header = Activity::FindOrFail($result);
                return response()->json(['success' => true, "header" => $header]);
            } else {
                return response()->json(['success' => false]);
            }
        }
    }

    public function edit($id) {
        $record = Activity::FindOrFail($id);
        return response()->json($record);
    }

    public function update(Request $request, $id) {
        $record = Activity::FindOrFail($id);
        $input = $request->all();
        $result = $record->fill($input)->save();
        if ($result) {

            $data = Activity::FindOrFail($id);
            return response()->json(['success' => true, "data" => $data]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function destroy($id) {
        $record = Activity::FindOrFail($id);
        $result = $record->delete();

        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

}
