<?php

namespace App\Models\Security;

use Illuminate\Database\Eloquent\Model;

class RolesPermission extends Model {

    protected $table = "roles_permission";
    protected $primaryKey = "id";
    protected $fillable = ["id", "permission_id","role_id"];

}
