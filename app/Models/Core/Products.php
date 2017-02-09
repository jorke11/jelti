<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table="products";
    protected $primaryKey='id';
    protected $fillable=["id",
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
        "categories_id",
        "supplier_id",
        "url_part",
        "bar_code",
        "status_id",
        "meta_title",
        "meta_keywords",
        "meta_description",
        "minimun_stock",
        "image",
        ];
    public $timestamp=false;
}
