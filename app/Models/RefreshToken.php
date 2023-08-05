<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefreshToken extends Model
{
    use HasFactory;

    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'user_id',
        'expired_time'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
