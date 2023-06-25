<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes');
    }

    public function isLikedBy(User $user)
    {
        return $this->likes->contains('id', $user->id);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
