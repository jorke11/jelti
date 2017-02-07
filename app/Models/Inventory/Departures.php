<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Departure extends Model
{
    protected $table="departures";
    protected $primaryKey='id';
    public $timestamp=false;
}
