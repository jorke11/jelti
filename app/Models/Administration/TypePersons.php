<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class TypePersons extends Model {

    protected $table = "typepersons";
    protected $primaryKey = "typeperson_id";
    protected $fillable = ["typeperson_id", "description"];
}
