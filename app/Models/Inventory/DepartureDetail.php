<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class DepartureDetail extends Model
{
     protected $table = 'departure_detail';
    protected $primaryKey = "id";
    protected $fillable = [
        "id", 
        "departure_id", 
        "product_id", 
        "category_id", 
        "mark_id", 
        "quantity", 
        "value"
        ];
}
