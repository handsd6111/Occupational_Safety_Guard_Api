<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Victim extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        "name",
        "id_number",
        "service_unit",
        "phone",
        "employment_date",
        "birthday",
        "address",
        "degree_of_injury",
        "ar_id"
    ];

    public function accidentRecord(): BelongsTo
    {
        return $this->belongsTo(AccidentRecord::class, 'ar_id', 'id');
    }
}
