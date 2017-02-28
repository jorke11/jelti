<?php

namespace App\Models\Security;

use Illuminate\Database\Eloquent\Model;

class PermissionsUser extends Model {

    protected $table = "permissions_user";
    protected $primaryKey = "permission_user_id";
    protected $fillable = ["permission_user_id", "users_id", "permission_id"];
}
