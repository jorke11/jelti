<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model {

    protected $table = "contact";
    protected $primaryKey = "id";
    protected $fillable = [
        "id",
        "name",
        "last_name",
        "document",
        "email",
    ];

}
