<?php

namespace App\Models\Seller;

use Illuminate\Database\Eloquent\Model;

class Prospect extends Model {

    protected $table = "prospects";
    protected $primaryKey = "id";
    protected $fillable = ["id", "status_id","status_prospect_id", "source_id", "sector_id", "city_id", "commercial_id", "name", "last_name", "business", "business_name",
        "email", "position", "phone", "mobile", "web_site", "id_skype", "id_twitter", "address",];

}
