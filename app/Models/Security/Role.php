<?php

namespace App\Models\Security;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {

    protected $table = "role";
    protected $primaryKey = "id";
    protected $fillable = ["id", "description"];

}
