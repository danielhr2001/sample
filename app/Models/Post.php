<?php

namespace App\Models;

use App\Models\User;
use App\Models\PostUserLike;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'body',
        'user_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function postUserLikes()
    {
        return $this->hasMany(PostUserLike::class);
    }
}
