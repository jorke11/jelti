<?php

namespace App\Models\Security;

use Illuminate\Database\Eloquent\Model;

class PermissionUser extends Model {

    protected $table = "permissionuser";
    protected $primaryKey = "id";
    protected $fillable = ["id", "users_id", "permission_id"];

}
