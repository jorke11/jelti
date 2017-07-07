<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class Products extends Model {

    protected $table = "products";
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
        "url_part",
        "bar_code",
        "status_id",
        "meta_title",
        "meta_keywords",
        "meta_description",
        "minimum_stock",
        "characteristic",
        "account_id",
        "packaging",
        
    ];
    
    public $timestamp = false;

}
