<?php

namespace App\Models\Invoicing;

use Illuminate\Database\Eloquent\Model;

class Purchases extends Model
{
    protected $table='purchases';
    protected $primaryKey="id";
    protected $fillable=["id","description","warehouse_id","city_id","supplier_id","avoice","created","status_id","responsible_id"];
}
