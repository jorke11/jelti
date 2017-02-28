<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class TypeRegimes extends Model {

    protected $table = "typeregimes";
    protected $primaryKey = "typeregime_id";
    protected $fillable = ["typeregime_id", "description"];

}
