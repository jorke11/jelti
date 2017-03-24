<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
//use App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth;
use App\Models\Administration\Comment;

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
        
        

        switch (Auth::user()->role_id) {
            case 1: {
                    return view('dashboard', compact("comment"));
                    break;
                }
            case 2: {
                    return view('client');
                    break;
                }
            case 3: {
                    return view('supplier');
                    break;
                }
        }
    }

}
