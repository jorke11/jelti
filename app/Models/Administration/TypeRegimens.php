<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class TypeRegimens extends Model {

    protected $table = "typeregimes";
    protected $primaryKey = "id";
    protected $fillable = ["id", "description"];

}
