<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Administration\Comment;
use Auth;

class LogController extends Controller {

    public function logClient($client_id, $comment) {
        $in["user_id"] = Auth::user()->id;
        $in["stakeholder_id"] = $client_id;
        $in["description"] = $comment;
        Comment::create($in);
    }

}
