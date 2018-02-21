<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class InventoryLog extends Model {

    protected $table = "inventory_log";
    protected $primaryKey = "id";
    protected $fillable = ["id", "product_id", "warehouse_id", "value", "expiration_date", "quantity", "lot", "description", "insert_id", "update_id","type_move","row_id"];

}
