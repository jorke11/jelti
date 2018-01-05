<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    protected $table = "categories_blog";
    protected $primaryKey = "id";
    protected $fillable = ["id", "description", "short_description", "order", "status_id", "type_category_id", "node_id"];

}
