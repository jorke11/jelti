<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

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
        "update_id",
        "type_product_id",
        "warehouse",
        "pvp",
        "is_new",
        "about",
        "why",
        "ingredients",
        "measure_product",
        "measure_box",
        "measure_master",
        "content_product",
        "expire_month"
    ];
    
    public $timestamp = false;
    
    use Sluggable,
        SluggableScopeHelpers;
    

    public function sluggable() {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

}
