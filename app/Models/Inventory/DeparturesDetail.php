<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class DeparturesDetail extends Model {

    protected $table = 'departures_detail';
    protected $primaryKey = "id";
    protected $fillable = [
        "id",
        "departure_id",
        "product_id",
        "status_id",
        "mark_id",
        "quantity",
        "value",
        "units_sf",
        "real_quantity",
        "description",
        "units_sf",
        "tax",
        "packaging",
        "entry_detail_id",
        "exento",
        "tax5",
        "tax5_real",
        "tax19",
        "tax19_real",
        "subtotal",
        "subtotal_real",
        "total",
        "total_real",
    ];

}
