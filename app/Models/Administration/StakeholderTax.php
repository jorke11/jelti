<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class StakeholderTax extends Model {

    protected $table = "stakeholder_tax";
    protected $primaryKey = "id";
    protected $fillable = ["id", "tax_id", "stakeholder_id"];

}
