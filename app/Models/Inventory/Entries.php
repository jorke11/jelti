<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Entries extends Model
{
    protected $table='entries';
    protected $primaryKey="id";
    public $timestamp=false;
}
