<?php

namespace App\Models\Invoicing;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model {

    protected $table = "sale";
    protected $primaryKey = 'id';
    protected $fillable = [
        "id",
        "sale_id",
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
