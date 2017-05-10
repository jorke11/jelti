<?php

namespace App\Models\Uploads;

use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
    protected $table = "bases";
    protected $primaryKey = "id";
    protected $fillable = ["id", "name","quantity","path","quantity_upload"];
}


