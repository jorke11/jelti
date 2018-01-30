<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class TransferDetail extends Model {

    protected $table = 'transfer_detail';
    protected $primaryKey = "id";
    protected $fillable = [
        "id",
        "transfer_id",
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
    ];

}
