<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
   protected $table = "warehouse";
    protected $primaryKey = "id";
    protected $fillable = ["id", "description",'address'];
    public $timestamp = false;
}
