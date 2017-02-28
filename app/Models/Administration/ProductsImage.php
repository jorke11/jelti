<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class ProductsImage extends Model {
    protected $table = "products_image";
    protected $primaryKey = 'product_image_id';
    protected $fillable = ["product_image_id","product_id","path","main"];
}
