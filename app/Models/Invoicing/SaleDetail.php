<?php

namespace App\Models\Invoicing;

use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model {

    protected $table = 'sales_detail';
    protected $primaryKey = "id";
    protected $fillable = [
        "id",
        "sale_id",
        "product_id",
        "quantity",
        "tax",
        "account_id",
        "order",
        "value"
    ];

}
