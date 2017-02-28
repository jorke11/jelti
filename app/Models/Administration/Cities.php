<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    protected $table = "cities";
    protected $primaryKey = "city_id";
    protected $fillable = ["city_id", "description"];
    public $timestamp = false;

}
