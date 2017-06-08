<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

    protected $table = "comments";
    protected $primaryKey = "id";
    protected $fillable = ["id", "product_id", "stakeholder_id", "description","user_id"];

}
