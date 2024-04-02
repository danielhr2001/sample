<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OTP extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'user_id',
        'device_ip',
        'expire_at',
    ];

    public function user()
    {
        $this->belongsTo(User::class);
    }
}
