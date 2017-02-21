<?php

namespace App\Models\Billing;

use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model {

    protected $table = 'saledetail';
    protected $primaryKey = "id";
    protected $fillable = [
        "id",
        "sale_id",
        "product_id",
        "quantity",
        "value"
    ];

}
