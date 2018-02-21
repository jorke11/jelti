<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class InventoryHold extends Model {

    protected $table = "inventory_hold";
    protected $primaryKey = "id";
    protected $fillable = ["id", "row_id","product_id", "warehouse_id", "value", "expiration_date", "quantity", "lot", "description", "insert_id", "update_id"];

}
