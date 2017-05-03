<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class FileErrors extends Model
{
    protected $table = "file_error";
    protected $primaryKey = "id";
    protected $fillable = ["id", "base_id","data"];
}
