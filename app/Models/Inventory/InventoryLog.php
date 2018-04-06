<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class InventoryLog extends Model {

    protected $table = "inventory_log";
    protected $primaryKey = "id";
    protected $fillable = ["id", "product_id", "warehouse_id", "cost_sf", "expiration_date", "quantity","previous_quantity", "lot", "description", "insert_id", "update_id","type_move","row_id"];

}
