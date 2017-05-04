<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model {

    protected $table = "branch_office";
    protected $primaryKey = "id";
    protected $fillable = ["id", "stakeholder_id", "city_id", "web_site", "name",
        "address_invoice", "address_send", "invoice_city_id", "send_city_id", "email",
        "term", "mobile", "business_name", "nit", "verification", "status_id", "user_insert", 
        "document"];

}
