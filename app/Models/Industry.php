<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'code';
    protected $keyType = 'string';
    public $timestamps = false;
}
