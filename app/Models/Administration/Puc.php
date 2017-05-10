<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class Puc extends Model {

    protected $table = "puc";
    protected $primaryKey = "id";
    protected $fillable = ["id", "code","account","level","nature"];

}
