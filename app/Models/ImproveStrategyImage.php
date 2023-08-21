<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImproveStrategyImage extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    public function accidentRecord(): BelongsTo {
        return $this->belongsTo(AccidentRecord::class, 'ar_id', 'id');
    }
}
