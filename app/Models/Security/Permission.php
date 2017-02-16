<?php

namespace App\Models\Security;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = "permission";
    protected $primaryKey = "id";
    protected $fillable = ["id", "parent_id","description","controller","title","alternative","event"];
    public $timestamp = false;
}
