<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
//use App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth;

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
        switch (Auth::user()->role_id) {
            case 1: {
                    return view('dashboard');
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
