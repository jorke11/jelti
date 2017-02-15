<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class Productimage extends Model {
    protected $table = "productimage";
    protected $primaryKey = 'id';
    protected $fillable = ["id","product_id","path","main"];
}
