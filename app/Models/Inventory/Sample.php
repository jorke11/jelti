<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Sample extends Model {

    protected $table = "samples";
    protected $primaryKey = "id";
    protected $fillable = [
        "id",
        "responsible_id",
        "branch_id",
        "city_id",
        "client_id",
        "warehouse_id",
        "created",
        "destination_id",
        "address",
        "phone",
        "status_id",
        "shipping_cost",
        "invoice",
        "description",
        "paid_out",
        "transport",
        "insert_id",
        "update_id",
        "outstanding",
        "remission",
        "discount",
        "type_inventory_id",
        "total",
        "subtotal",
        "quantity",
    ];

}
