<?php

namespace App\Models\Invoicing;

use Illuminate\Database\Eloquent\Model;

class PurchasesDetail extends Model {

    protected $table = 'purchases_detail';
    protected $primaryKey = "id";
    protected $fillable = [
        "id", 
        "purchase_id", 
        "product_id", 
        "category_id", 
        "mark_id", 
        "quantity", 
        "lot", 
        "expiration_date", 
        "value"
        ];

}
