<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class Cities extends Model {

    protected $table = "cities";
    protected $primaryKey = "id";
    protected $fillable = ["id", "description", "department_id","code"];

}
