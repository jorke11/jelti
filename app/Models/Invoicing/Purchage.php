<?php

namespace App\Models\Invoicing;

use Illuminate\Database\Eloquent\Model;

class Purchage extends Model
{
    protected $table='purchage';
    protected $primaryKey="id";
    protected $fillable=["id","description","warehouse_id","city_id","supplier_id","avoice","created","status_id","responsable_id"];
}
