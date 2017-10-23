<?php

namespace App\Models\Invoicing;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model {

    protected $table = "sales";
    protected $primaryKey = 'id';
    protected $fillable = [
        "id",
        "warehouse_id",
        "client_id",
        "product_id",
        "category_id",
        "responsible_id",
        "city_id",
        "destination_id",
        "order",
        "address",
        "phone",
        "description",
        "status_id",
        "created",
        "invoice",
        "dispatched",
        "responsible",
        "warehouse",
        "city",
        "client",
        "destination",
        "shipping_cost_tax"
    ];

}
