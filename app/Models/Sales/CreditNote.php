<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Model;

class CreditNote extends Model {

    protected $table = "credit_note";
    protected $primaryKey = "id";
    protected $fillable = ["id", "sale_id","departure_id","sale_id"];

}
