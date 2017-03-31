<?php

namespace App\Http\Controllers\Administration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Administration\Ticket;
use App\Models\Administration\TicketComment;
use App\Models\Administration\Parameters;
use App\Models\Security\Users;

class TicketController extends Controller {

    public function __construct() {
        $this->middleware("auth");
    }

    public function index() {
        $depart = Parameters::where("group", "department")->get();
        $status = Parameters::where("group", "ticket")->get();
        $priority = Parameters::where("group", "priority")->get();
        $user = Users::all();
        return view("Administration.ticket.init", compact("depart", "priority", "user", "status"));
    }

    public function create() {
        return "create";
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);
//            $user = Auth::User();
            $input["status_id"] = 1;
            $result = Ticket::create($input);
            if ($result) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false]);
            }
        }
    }

    public function addComment(Request $request) {
        if ($request->ajax()) {
            $input = $request->all();
            unset($input["id"]);
//            $user = Auth::User();
            $result = TicketComment::create($input);
            if ($result) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false]);
            }
        }
    }

    public function edit($id) {
        $suppliers = Ticket::FindOrFail($id);
        return response()->json($suppliers);
    }

    public function update(Request $request, $id) {
        $category = Ticket::FindOrFail($id);
        $input = $request->all();
        $result = $category->fill($input)->save();
        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function destroy($id) {
        $category = Ticket::FindOrFail($id);
        $result = $category->delete();
        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

}
