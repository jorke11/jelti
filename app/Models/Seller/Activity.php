<?php

namespace App\Models\Seller;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = "activities";
    protected $primaryKey = "id";
    protected $fillable = ["id", "commercial_id", "subject", "expiration_date",
        "commercial_id", "name", "last_name","notification","priority_id","status_id"];

}
