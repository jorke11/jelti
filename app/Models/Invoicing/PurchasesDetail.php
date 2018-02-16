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
        "quantity", 
        "real_quantity", 
        "lot", 
        "expiration_date", 
        "value",
        "order",
        "type_nature",
        "payed",
        "type_nature",
        "account_id",
        "description",
        "units_supplier",
        "tax",
        "parent_id",
        ];

}
