<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Model;

class CreditNoteDetail extends Model
{
    protected $table = "credit_note_detail";
    protected $primaryKey = "id";
    protected $fillable = ["id", "creditnote_id", "row_id","quantity"];
}
