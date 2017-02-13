<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Departure extends Model {

    protected $table = "departure";
    protected $primaryKey = 'id';
    protected $fillable = [
        "id",
        "entry_id",
        "warehouse_id",
        "supplier_id",
        "product_id",
        "category_id",
        "responsable_id",
        "city_id",
        "consecutive",
        "destination",
        "order",
        "address",
        "description",
        "created",
    ];

}
