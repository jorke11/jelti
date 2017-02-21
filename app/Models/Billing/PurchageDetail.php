<?php

namespace App\Models\Billing;

use Illuminate\Database\Eloquent\Model;

class PurchageDetail extends Model {

    protected $table = 'purchagedetail';
    protected $primaryKey = "id";
    protected $fillable = [
        "id", 
        "purchage_id", 
        "supplier_id", 
        "product_id", 
        "category_id", 
        "mark_id", 
        "quantity", 
        "lot", 
        "expiration_date", 
        "value"
        ];

}
