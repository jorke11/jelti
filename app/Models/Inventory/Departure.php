<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Departure extends Model {

    protected $table = "departure";
    protected $primaryKey = "id";
    protected $fillable = ["id", "consecutive", "responsable_id", "order", "city_id", "supplier_id","warehouse_id","created","destination_id","address","phone"];

}
