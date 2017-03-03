<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model {

    protected $table = "branch_office";
    protected $primaryKey = "id";
    protected $fillable = ["id", "client_id", "city_id", "address", "name", "phone"];

}
