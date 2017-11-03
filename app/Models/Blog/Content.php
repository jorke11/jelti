<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
       protected $table = "blog";
    protected $primaryKey = "id";
    protected $fillable = ["id", "title", "content", "user_id"];
}
