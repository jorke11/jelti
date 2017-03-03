<?php

namespace App\Models\Security;

use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{
    protected $table = "permissions";
    protected $primaryKey = "id";
    protected $fillable = ["id", "parent_id","typemenu_id","icon","description","controller","title","alternative","event","priority"];
}
