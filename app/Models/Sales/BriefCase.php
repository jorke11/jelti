<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Model;

class BriefCase extends Model {

    protected $table = "briefcase";
    protected $primaryKey = "id";
    protected $fillable = ["id", "departure_id", "value", "img"];

}
