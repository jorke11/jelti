<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model {

    protected $table = "contacts";
    protected $primaryKey = "id";
    protected $fillable = [
        "id",
        "commercial_id",
        "source_id",
        "stakeholder_id",
        "city_id",
        "name",
        "last_name",
        "email",
        "position",
        "phone",
        "mobile",
        "birth_date",
        "web_site",
        "id_skype",
        "id_twitter",
        "address",
    ];

}
