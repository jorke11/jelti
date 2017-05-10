<?php

namespace App\Models\Security;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model {

    protected $table = "roles";
    protected $primaryKey = "id";
    protected $fillable = ["id", "description"];

}
