<?php

namespace App\Models\Seller;

use Illuminate\Database\Eloquent\Model;

class FulfillmentDetail extends Model {

    protected $table = "fulfillment_detail";
    protected $primaryKey = "id";
    protected $fillable = ["id", "commercial_id", "fulfillment_id", "value"];

}
