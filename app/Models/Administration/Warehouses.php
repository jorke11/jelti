<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class Warehouses extends Model
{
   protected $table = "warehouses";
    protected $primaryKey = "id";
    protected $fillable = ["id", "description",'address'];
    public $timestamp = false;
}