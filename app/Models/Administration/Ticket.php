<?php

namespace App\Models\Administration;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = "tickets";
    protected $primaryKey = "id";
    protected $fillable = ["id", "subject","description","priority_id","department_id","status_id","assigned_id"];
}
