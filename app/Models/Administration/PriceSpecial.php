<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class PriceSpecial extends Model {

    protected $table = "pricespecial";
    protected $primaryKey = "id";
    protected $fillable = ["id", "supplier_id","product_id","price_cust"];

}
