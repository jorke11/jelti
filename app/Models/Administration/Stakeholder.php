<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class Stakeholder extends Model
{
    protected $table = "stakeholder";
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
        "status_id",
        "commercial_id",
        "web_site",
        "type_regime_id",
        "type_person_id",
        "type_stakeholder",
        "type_document",
        "type_stakeholder",
        "business_name",
        "business",
        "lead_time",
        ];
}
