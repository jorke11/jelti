<?php

namespace App\Models\Uploads;

use Illuminate\Database\Eloquent\Model;

class UploadProducts extends Model {

    protected $table = "upload_products";
    protected $primaryKey = "id";
    protected $fillable = [
        "id",
        "category_id",
        "supplier_id",
        "title",
        "description",
        "short_description",
        "reference",
        "units_supplier",
        "units_sf",
        "cost_sf",
        "tax",
        "price_sf",
        "price_cust",
        "url_part",
        "bar_code",
        "status",
        "meta_title",
        "meta_keywords",
        "meta_description",
        "minimum_stock",
        "characteristic",
        "account_id",
        "packaging",
        "previous"
    ];

}
