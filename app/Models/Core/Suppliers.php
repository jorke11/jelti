<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table='suppliers';
    protected $primaryKey="id";
    public $timestamp=false;
}
