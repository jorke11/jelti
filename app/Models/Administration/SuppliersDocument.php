<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class SuppliersDocument extends Model {

    protected $table = "suppliers_document";
    protected $primaryKey = 'supplier_document_id';
    protected $fillable = ["supplier_document_id", "supplier_id", "document_id", "path"];

}
