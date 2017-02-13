<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = "city";
    protected $primaryKey = "id";
    protected $fillable = ["id", "description"];
    public $timestamp = false;

}
