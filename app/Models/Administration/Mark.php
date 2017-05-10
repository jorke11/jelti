<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    protected $table = "mark";
    protected $primaryKey = "id";
    protected $fillable = ["id", "description"];
}
