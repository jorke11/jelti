<?php

namespace App\Models\Secutiry;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table="permissions";
    protected $primaryKey="id";
    public $timestamp=false;
}
