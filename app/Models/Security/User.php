<?php

namespace App\Models\Security;

use Illuminate\Database\Eloquent\Model;

class User extends Model {

    protected $table = "users";
    protected $primaryKey = "id";
    protected $fillable = ["id", "name","email","city_id","supplier_id","profile_id","status","password","remember_token"];

}
