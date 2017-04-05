<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class DeparturesDetail extends Model
{
     protected $table = 'departures_detail';
    protected $primaryKey = "id";
    protected $fillable = [
        "id", 
        "departure_id", 
        "product_id", 
        "status_id", 
        "mark_id", 
        "quantity", 
        "value",
        "real_quantity",
        "description",
        ];
}
