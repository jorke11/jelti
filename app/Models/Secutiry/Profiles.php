<?php

namespace App\Models\Secutiry;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table="profiles";
    protected $primaryKey='id';
    public $timestamp=false;
}
