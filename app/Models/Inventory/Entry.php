<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    protected $table='entry';
    protected $primaryKey="id";
    protected $fillable=["id","consecutive","description","warehouse_id","bill","created","responsable_id"];
}
