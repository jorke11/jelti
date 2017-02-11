<?php
namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    protected $table = "category";
    protected $primaryKey = "id";
    protected $fillable = ["id", "description"];
    public $timestamp = false;

}
