<?php

namespace App\Models;

use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Parsedown;

class Post extends Model
{
    /** @use HasFactory<PostFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'category_id',
        'author_id',
        'slug',
        'status',
        'image',
        'views',
        'published_at',
        'description',
    ];

    public function getImageUrl(): string
    {
        if (!$this->image) {
            return asset('img/cover.png');
        }

        return Storage::disk('public')->exists($this->image)
            ? Storage::url($this->image)
            : asset('img/cover.png');
    }

    public function route(): string
    {
        return route('posts.show', ['slug' => $this->slug, 'post' => $this->id]);
    }

    public function parsedContent(): string
    {
        $parsedown = new Parsedown();
        $parsedown->setSafeMode(true);
        $parsedown->setBreaksEnabled(true);

        return $parsedown->text($this->content);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getTagsCountAttribute(): int
    {
        return $this->tags()->count();
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    #[Scope]
    protected function minimal(Builder $query): void
    {
        $table = $query->getModel()->getTable();

        $query->select([
            "{$table}.id",
            "{$table}.title",
            "{$table}.slug",
            "{$table}.description",
            "{$table}.image",
            "{$table}.author_id",
            "{$table}.category_id",
            "{$table}.created_at",
        ]);
    }

    #[Scope]
    protected function published(Builder $query): void
    {
        $query->where('status', 'published');
    }

    public function getCommentsCountAttribute(): int
    {
        return $this->comments()->count();
    }
}
