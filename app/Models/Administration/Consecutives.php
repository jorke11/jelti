<?php

namespace App\models\Administration;

use Illuminate\Database\Eloquent\Model;

class Consecutives extends Model {

    protected $table = "consecutives";
    protected $primaryKey = "id";
    protected $fillable = ["id", "description", "type_form", "initial", "final", "current", "large"];

}
