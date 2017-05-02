<?php

namespace App\Http\Controllers\Administration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Email;
use App\Models\Administration\EmailDetail;

class EmailController extends Controller {

    public function __construct() {
        $this->middleware("auth");
    }

    public function index() {
        return view("Administration.email.init");
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);
//            $user = Auth::User();
//            $input["users_id"] = 1;

            $result = Email::create($input)->id;
            if ($result) {
                $header = Email::FindOrFail($result);
                return response()->json(['success' => true, "header" => $header]);
            } else {
                return response()->json(['success' => false]);
            }
        }
    }

    public function storeDetail(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);
//            $user = Auth::User();
//            $input["users_id"] = 1;

            $result = EmailDetail::create($input)->id;
            if ($result) {
                $detail = EmailDetail::where("email_id", $input["email_id"])->get();
                return response()->json(['success' => true, "detail" => $detail]);
            } else {
                return response()->json(['success' => false]);
            }
        }
    }

    public function edit($id) {
        $record = Email::FindOrFail($id);
        $detail = EmailDetail::where("email_id", $record->id)->get();
        return response()->json(["header" => $record, "detail" => $detail]);
    }

    public function editDetail($id) {
        $detail = EmailDetail::findOrFail($id);
        return response()->json($detail);
    }

    public function update(Request $request, $id) {
        $record = Email::FindOrFail($id);
        $input = $request->all();
        $result = $record->fill($input)->save();
        if ($result) {

            $data = Email::FindOrFail($id);
            return response()->json(['success' => true, "data" => $data]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function updateDetail(Request $request, $id) {
        $input = $request->all();
        $record = EmailDetail::FindOrFail($id);
        $input = $request->all();
        $result = $record->fill($input)->save();
        if ($result) {
            $data = EmailDetail::where("email_id", $input["email_id"])->get();
            return response()->json(['success' => true, "detail" => $data]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function destroy($id) {
        $record = Email::FindOrFail($id);
        $result = $record->delete();

        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function destroyDetail(Request $req, $id) {
        $input = $req->all();
        $record = EmailDetail::FindOrFail($id);
        $result = $record->delete();

        if ($result) {
            $data = EmailDetail::where("email_id", $input["email_id"])->get();
            return response()->json(['success' => true, "detail" => $data]);
        } else {
            return response()->json(['success' => false]);
        }
    }

}
