<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Post extends Model {

    use Sluggable,
        SluggableScopeHelpers;

    protected $table = "posts";
    protected $primaryKey = "id";
    protected $fillable = ["id", "title", "content", "tags", "user_id", "img", "thumbnail", "published", "products_id","category_id"];

    public function sluggable() {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

}
