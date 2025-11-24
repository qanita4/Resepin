<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipeCommentController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RecipeLikeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [RecipeController::class, 'index'])
    // ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/dashboard', [RecipeController::class, 'index'])
    // ->middleware(['auth', 'verified'])
    ->name('dashboard');

// -- create & store harus sebelum route show supaya '/recipes/create' tidak tertangkap oleh {recipe:slug}
Route::get('/recipes/create', [RecipeController::class, 'create'])
    ->middleware(['auth'])
    ->name('recipes.create');

Route::post('/recipes', [RecipeController::class, 'store'])
    ->middleware(['auth'])
    ->name('recipes.store');

Route::get('/recipes/{recipe:slug}', [RecipeController::class, 'show'])
    // ->middleware(['auth', 'verified'])
    ->name('recipes.show');

Route::post('/recipes/{recipe:slug}/likes', [RecipeLikeController::class, 'store'])
    ->middleware(['auth', 'verified'])
    ->name('recipes.likes.store');

Route::delete('/recipes/{recipe:slug}/likes', [RecipeLikeController::class, 'destroy'])
    ->middleware(['auth', 'verified'])
    ->name('recipes.likes.destroy');

Route::post('/recipes/{recipe:slug}/comments', [RecipeCommentController::class, 'store'])
    ->middleware(['auth', 'verified'])
    ->name('recipes.comments.store');

Route::delete('/recipes/{recipe:slug}/comments/{comment}', [RecipeCommentController::class, 'destroy'])
    ->middleware(['auth', 'verified'])
    ->name('recipes.comments.destroy');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
