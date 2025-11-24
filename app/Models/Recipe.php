<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\RecipeLike;
use App\Models\RecipeComment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'chef',
        'initial_rating',
        'description',
        'image',
        'badge',
        'duration',
        'servings',
        'difficulty',
        'ingredients',
        'steps',
        'user_id', // added
    ];

    protected $casts = [
        'initial_rating' => 'float',
        'ingredients' => 'array',
        'steps' => 'array',
        'liked_by_current_user' => 'boolean',
        'user_id' => 'integer', // added
    ];

    protected $appends = [
        'is_liked',
    ];

    public function likes(): HasMany
    {
        return $this->hasMany(RecipeLike::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(RecipeComment::class);
    }

    // new: relation to user who created recipe
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeWithLikeMeta($query): void
    {
        $query->withCount('likes');

        if (Auth::check()) {
            $userId = Auth::id();

            $query->withExists([
                'likes as liked_by_current_user' => fn ($likeQuery) => $likeQuery->where('user_id', $userId),
            ]);
        }
    }

    public function getIsLikedAttribute(): bool
    {
        if (! Auth::check()) {
            return false;
        }

        if (array_key_exists('liked_by_current_user', $this->attributes)) {
            return (bool) $this->attributes['liked_by_current_user'];
        }

        if ($this->relationLoaded('likes')) {
            return $this->likes->contains('user_id', Auth::id());
        }

        return $this->likes()->where('user_id', Auth::id())->exists();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
