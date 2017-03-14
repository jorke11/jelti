<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
     protected $table = "orders";
    protected $primaryKey = "id";
    protected $fillable = [
        "id",
        "stakeholder_id", 
        "address",
        "phone",
        "status_id"];
}
