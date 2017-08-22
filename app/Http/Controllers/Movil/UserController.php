<?php

namespace App\Http\Controllers\Movil;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Security\Users;
use App\Models\Administration;
use App\Models\Administration\Categories;

class UserController extends Controller {

    public function getUser($email) {
        $user = Users::where("email", $email)->first();
        return response()->json($user);
    }

    public function getCategories() {
        $data = Categories::where("status_id", 1)->get();
        return response()->json($data);
    }

}
