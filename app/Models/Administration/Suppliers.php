<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model {

    protected $table = "suppliers";
    protected $primaryKey = "id";
    protected $fillable = [
        "id",
        "name",
        "last_name",
        "document",
        "email",
        "address",
        "phone",
        "contact",
        "phone_contact",
        "term",
        "city_id",
        "commercial_id",
        "web_site",
        "type_regime_id",
        "type_person_id"];

//    public $timestamp = false;
}