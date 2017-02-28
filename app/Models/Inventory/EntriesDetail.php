<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class EntriesDetail extends Model
{
    protected $table = 'entries_detail';
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
