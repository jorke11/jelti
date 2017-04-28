<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class EmailDetail extends Model {

    protected $table = "email_detail";
    protected $primaryKey = "id";
    protected $fillable = ["id", "email_id","description"];

}
