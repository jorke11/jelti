<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    protected $table = "entry";
    protected $primaryKey = "id";
    protected $fillable = ["id", "consecutive","description","responsable_id","bill","description","city_id","supplier_id","warehouse_id","created"];
}
