<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Categories extends Model {

    protected $table = "categories";
    protected $primaryKey = "id";
    protected $fillable = ["id", "description", "short_description", "order", "status_id", "type_category_id", "node_id"];

    use Sluggable,
        SluggableScopeHelpers;

    public function sluggable() {
        return [
            'slug' => [
                'source' => 'description'
            ]
        ];
    }

}
