<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
//use App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth;
use App\Models\Administration\Comment;
use App\Models\Security\Users;
use App\Models\Security\Roles;
use App\Models\Administration\Warehouses;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $comment = Comment::whereBetween('created_at', array(date("Y-m") . "-01 00:00", date("Y-m") . "-31 23:59"));
        $comment = count($comment) + 1;

        if (Auth::user()->status_id == 3) {
            $users = Auth::user();
            $roles = Roles::where("id", $users->role_id)->get();
            $warehouses = Warehouses::all();
            return view('activation', compact("users", "roles","warehouses"));
        } else {
            return view('dashboard', compact("comment"));
        }
    }

}
