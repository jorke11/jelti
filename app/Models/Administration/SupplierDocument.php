<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class SupplierDocument extends Model {

    protected $table = "supplierdocument";
    protected $primaryKey = 'id';
    protected $fillable = ["id", "supplier_id", "document_id", "path"];

}
