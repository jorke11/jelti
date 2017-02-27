<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Departure extends Model {

    protected $table = "departure";
    protected $primaryKey = "id";
    protected $fillable = [
        "id",
        "responsable_id", 
        "branch_id", 
        "city_id", 
        "client_id",
        "warehouse_id",
        "created",
        "destination_id",
        "address",
        "phone",
        "status_id"];

}
