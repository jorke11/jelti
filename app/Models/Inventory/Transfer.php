<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model {

    protected $table = "transfer";
    protected $primaryKey = "id";
    protected $fillable = [
        "id",
        "origin_id",
        "destination_id",
        "city_id",
        "status_id",
        "insert_id",
        "created",
        "date_dispatched"
    ];

}
