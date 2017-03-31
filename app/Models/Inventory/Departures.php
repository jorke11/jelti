<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Departures extends Model {

    protected $table = "departures";
    protected $primaryKey = "id";
    protected $fillable = [
        "id",
        "responsible_id", 
        "branch_id", 
        "city_id", 
        "client_id",
        "warehouse_id",
        "created",
        "destination_id",
        "address",
        "phone",
        "status_id",
        "invoice"];

}