<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model {

    protected $table = "inventory";
    protected $primaryKey = "id";
    protected $fillable = ["id", "product_id", "warehouse_id", "cost_sf", "expiration_date", "quantity", "lot", "description", "insert_id", "update_id"];

}
