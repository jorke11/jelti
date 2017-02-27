<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
     protected $table = "order";
    protected $primaryKey = "id";
    protected $fillable = [
        "id",
        "consecutive",
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
