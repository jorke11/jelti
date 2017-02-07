<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table="products";
    protected $primaryKey='id';
    public $timestamp=false;
}
