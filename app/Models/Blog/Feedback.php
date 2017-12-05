<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
     protected $table = "feedback";
    protected $primaryKey = "id";
    protected $fillable = ["id", "content", "user_id","type_id","title","row_id","email","name"];
}
