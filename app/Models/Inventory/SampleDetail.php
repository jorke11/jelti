<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class SampleDetail extends Model {

    protected $table = 'samples_detail';
    protected $primaryKey = "id";
    protected $fillable = [
        "id",
        "sample_id",
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
        "quantity_lots"
    ];

}
