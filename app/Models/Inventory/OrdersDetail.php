<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class OrdersDetail extends Model {

    protected $table = 'orders_detail';
    protected $primaryKey = "id";
    protected $fillable = [
        "id",
        "order_id",
        "product_id",
        "category_id",
        "mark_id",
        "quantity",
        "generate",
        "status_id",
        "pending",
        "value"
    ];

}
