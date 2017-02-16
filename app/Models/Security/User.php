<?php

namespace App\Models\Security;

use Illuminate\Database\Eloquent\Model;

class User extends Model {

    protected $table = "users";
    protected $primaryKey = "id";
    protected $fillable = ["id", "name","email","password","remember_token"];

}
