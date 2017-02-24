<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model {

    protected $table = "entry";
    protected $primaryKey = "id";
    protected $fillable = ["id", "description", "responsable_id", "avoice", "description", "city_id", "supplier_id", "warehouse_id", "created", "status_id"];

}
