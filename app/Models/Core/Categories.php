<?php
namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model {

    protected $table = "categories";
    protected $primaryKey = "id";
    protected $fillable = ["id", "description"];
    public $timestamp = false;

}
