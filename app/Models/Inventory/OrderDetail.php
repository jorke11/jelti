<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model {

    protected $table = 'order_detail';
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
