<?php

namespace App\Models\Security;

use Illuminate\Database\Eloquent\Model;

class Users extends Model {

    protected $table = "users";
    protected $primaryKey = "id";
    protected $fillable = ["id", "name", "last_name", "email", "city_id",
        "stakeholder_id", "warehouse_id", "role_id", "status_id",
        "password", "remember_token","document"];

}
