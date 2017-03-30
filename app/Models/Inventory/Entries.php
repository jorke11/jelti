<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Entries extends Model {

    protected $table = "entries";
    protected $primaryKey = "id";
    protected $fillable = ["id", "consecutive", "description", "responsible_id", "invoice", "description", "city_id", "supplier_id", "warehouse_id", "created", "status_id"];

}
