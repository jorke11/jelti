<?php

namespace App\Models\Invoicing;

use Illuminate\Database\Eloquent\Model;

class PurchageDetail extends Model {

    protected $table = 'purchage_detail';
    protected $primaryKey = "id";
    protected $fillable = [
        "id", 
        "purchage_id", 
        "product_id", 
        "category_id", 
        "mark_id", 
        "quantity", 
        "lot", 
        "expiration_date", 
        "value"
        ];

}
