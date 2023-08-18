<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifyingAgency extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    // public function jurisdictionRegions() {
    //     return $this->hasMany(JurisdictionRegion::class, 'na_id', 'id');
    // }
}
