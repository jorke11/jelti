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
        "address",
        "document",
        "phone",
        "contact",
        "phone_contact",
        "type_regimen_id",
        "type_person_id"];

//    public $timestamp = false;
}
