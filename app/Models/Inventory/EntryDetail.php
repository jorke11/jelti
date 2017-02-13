<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class EntryDetail extends Model {

    protected $table = 'entrydetail';
    protected $primaryKey = "id";
    protected $fillable = [
        "id", 
        "entry_id", 
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
