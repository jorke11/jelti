<?php

namespace App\Models\Security;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model {

    protected $table = "profile";
    protected $primaryKey = "id";
    protected $fillable = ["id", "description"];

}
