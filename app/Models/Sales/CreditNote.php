<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Model;

class CreditNote extends Model {

    protected $table = "credit_note";
    protected $primaryKey = "id";
    protected $fillable = ["id", "departure_id", "quantity"];

}
