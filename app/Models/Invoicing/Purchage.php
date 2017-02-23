<?php

namespace App\Models\Invoicing;

use Illuminate\Database\Eloquent\Model;

class Purchage extends Model
{
    protected $table='purchage';
    protected $primaryKey="id";
    protected $fillable=["id","consecutive","description","warehouse_id","city_id","supplier_id","bill","created","responsable_id"];
}
