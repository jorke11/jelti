<?php

namespace App\Models\Seller;

use Illuminate\Database\Eloquent\Model;

class Fulfillment extends Model {

    protected $table = "fulfillment";
    protected $primaryKey = "id";
    protected $fillable = ["id", "year", "month", "value"];

}
