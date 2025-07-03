<?php

namespace App\Models;

use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    /** @use HasFactory<CategoryFactory> */
    use HasFactory;

    protected $fillable = ['name', 'description', 'slug', 'author_id'];

    public function getPostsCountAttribute(): int
    {
        return $this->posts()->count();
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function route(): string
    {
        return route('posts.category', $this->slug);
    }
}
