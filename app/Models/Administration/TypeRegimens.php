<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class TypeRegimens extends Model {

    protected $table = "type_regimens";
    protected $primaryKey = "id";
    protected $fillable = ["id", "description"];

}
