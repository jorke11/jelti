<?php

namespace App\Models\Security;

use Illuminate\Database\Eloquent\Model;

class Users extends Model {

    protected $table = "users";
    protected $primaryKey = "user_id";
    protected $fillable = ["user_id", "name","email","city_id","supplier_id","profile_id","status","password","remember_token"];

}
