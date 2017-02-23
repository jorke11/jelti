<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class EntryDetail extends Model
{
    protected $table = 'entry_detail';
    protected $primaryKey = "id";
    protected $fillable = [
        "id",
        "entry_id",
        "product_id",
        "category_id",
        "expiration_date",
        "lot",
        "quantity",
        "value"
    ];
}
