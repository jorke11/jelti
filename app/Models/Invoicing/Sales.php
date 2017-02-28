<?php

namespace App\Models\Invoicing;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model {

    protected $table = "sales";
    protected $primaryKey = 'sale_id';
    protected $fillable = [
        "sale_id",
        "sale_id",
        "warehouse_id",
        "supplier_id",
        "product_id",
        "category_id",
        "responsible_id",
        "city_id",
        "consecutive",
        "destination",
        "order",
        "address",
        "description",
        "created",
    ];

}
