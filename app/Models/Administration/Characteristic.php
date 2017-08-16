<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class Characteristic extends Model {

    protected $table = "products_characteristic";
    protected $primaryKey = "id";
    protected $fillable = ["id", "description","type_subcategory_id","order","status_id","img"];

}
