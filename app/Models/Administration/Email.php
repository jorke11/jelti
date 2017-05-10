<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $table = "email";
    protected $primaryKey = "id";
    protected $fillable = ["id", "description"];

}
