<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class TypePersons extends Model {

    protected $table = "typeperson";
    protected $primaryKey = "id";
    protected $fillable = ["id", "description"];
}
