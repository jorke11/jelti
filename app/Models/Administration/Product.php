<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

    protected $table = "product";
    protected $primaryKey = 'id';
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
        "minimun_stock",
        "image",
    ];
    public $timestamp = false;

}
