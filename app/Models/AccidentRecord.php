<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class AccidentRecord extends Model
{
    use HasFactory;

    public function improveStrategyImages(): HasMany
    {
        return $this->hasMany(ImproveStrategyImage::class, 'ar_id', 'id');
    }

    public function contractRelationshipImages(): HasMany
    {
        return  $this->hasMany(ContractRelationshipImage::class, 'ar_id', 'id');
    }

    public function causeOfAccidentImages(): HasMany
    {
        return $this->hasMany(CauseOfAccidentImage::class, 'ar_id', 'id');
    }

    public function victims(): HasMany
    {
        return $this->hasMany(Victim::class, 'ar_id', 'id');
    }
}
