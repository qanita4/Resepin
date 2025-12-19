<?php

namespace App\Services;

use App\Models\Recipe;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class RecipeSearchService
{
    /**
     * Get base query with common relations
     */
    public function getBaseQuery(): Builder
    {
        return Recipe::query()
            ->withLikeMeta()
            ->withCount('comments');
    }

    /**
     * Apply search filter to query
     */
    public function applySearch(Builder $query, string $searchTerm): Builder
    {
        if (empty($searchTerm)) {
            return $query;
        }

        $search = Str::lower($searchTerm);

        return $query->where(function ($subQuery) use ($search) {
            $subQuery
                ->whereRaw('LOWER(title) like ?', ["%{$search}%"])
                ->orWhereRaw('LOWER(chef) like ?', ["%{$search}%"])
                ->orWhereRaw('LOWER(description) like ?', ["%{$search}%"]);
        });
    }

    /**
     * Apply category filter to query
     */
    public function applyCategory(Builder $query, string $category): Builder
    {
        $kategoriMap = [
            'sarapan' => 'sarapan',
            'makan-siang' => 'makan siang',
            'makan-malam' => 'makan malam',
            'minuman' => 'minuman',
            'camilan' => 'camilan',
            'dessert' => 'dessert',
        ];

        if (isset($kategoriMap[$category])) {
            $query->whereRaw('LOWER(category) = ?', [strtolower($kategoriMap[$category])]);
        }

        return $query;
    }

    /**
     * Apply user filter to query
     */
    public function applyUserFilter(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Get popular recipes
     */
    public function getPopular(int $limit = 6)
    {
        return $this->getBaseQuery()
            ->where('likes_count', '>', 0)
            ->orderByDesc('likes_count')
            ->take($limit)
            ->get();
    }

    /**
     * Get latest recipes
     */
    public function getLatest(int $limit = 6)
    {
        return $this->getBaseQuery()
            ->orderByDesc('created_at')
            ->take($limit)
            ->get();
    }

    /**
     * Get related recipes based on category
     */
    public function getRelated(Recipe $recipe, int $limit = 3)
    {
        return $this->getBaseQuery()
            ->where('id', '!=', $recipe->id)
            ->where('category', $recipe->category)
            ->inRandomOrder()
            ->take($limit)
            ->get();
    }
}
