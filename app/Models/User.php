<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Boot the model.
     */
    protected static function booted(): void
    {
        static::deleting(function (User $user) {
            // Delete all recipes created by the user (this will cascade to likes/comments on those recipes)
            $user->recipes()->each(function ($recipe) {
                $recipe->delete();
            });

            // Delete all comments made by this user on other recipes
            $user->comments()->delete();

            // Delete all likes made by this user on other recipes
            $user->likes()->delete();
        });
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Get all recipes created by this user.
     */
    public function recipes(): HasMany
    {
        return $this->hasMany(Recipe::class);
    }

    /**
     * Get all comments made by this user.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(RecipeComment::class);
    }

    /**
     * Get all likes made by this user.
     */
    public function likes(): HasMany
    {
        return $this->hasMany(RecipeLike::class);
    }
}
