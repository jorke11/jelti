<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class TypeRegime extends Model {

    protected $table = "typeregime";
    protected $primaryKey = "id";
    protected $fillable = ["id", "description"];

}
