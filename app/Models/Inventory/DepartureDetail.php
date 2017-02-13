<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class DepartureDetail extends Model {

    protected $table = 'departuredetail';
    protected $primaryKey = "id";
    protected $fillable = [
        "id",
        "departure_id",
        "product_id",
        "quantity",
        "value"
    ];

}
