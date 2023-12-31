<?php

namespace App\Models;

use App\Models\Post;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    /**
     * The posts that the user likes.
     */
    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'likes', 'user_id', 'post_id')->withTimestamps();
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'favorites', 'user_id', 'post_id')->withTimestamps();
    }

    public function isFavoritedBy(User $user): bool
{
    return $this->favoritedBy()->where('user_id', $user->id)->exists();
}

}
