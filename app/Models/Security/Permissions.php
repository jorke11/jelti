<?php

namespace App\Models\Security;

use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{
    protected $table = "permissions";
    protected $primaryKey = "permission_id";
    protected $fillable = ["permission_id", "parent_id","typemenu_id","icon","description","controller","title","alternative","event","priority"];
}
