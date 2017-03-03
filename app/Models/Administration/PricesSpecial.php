<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class PricesSpecial extends Model {

    protected $table = "prices_special";
    protected $primaryKey = "id";
    protected $fillable = ["id", "client_id", "product_id", "price_sf","margin","margin_sf","tax"];

}
