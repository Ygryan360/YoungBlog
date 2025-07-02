<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Contracts\View\View;

class PostController extends Controller
{
    public function show(string $slug, Post $post): View
    {
        if ($post->status !== 'published') {
            abort(404);
        }
        $post->update(['views' => $post->views + 1]);
        return view('post', compact('post'));
    }

    public function preview(Post $post): View
    {
        if (auth()->user()->isAdminOrAuthor() || auth()->user()->isSuperAdmin()) {
            return view('post', compact('post'));
        }
        abort(403);
    }

    public function category(string $slug): View
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $posts = $category->posts()
            ->published()
            ->paginate(10);

        return view('category', compact('posts', 'category'));
    }

    public function tag(string $name): View
    {
        $tag = Tag::where('name', $name)->firstOrFail();
        $posts = $tag->posts()
            ->published()
            ->paginate(10);

        return view('tag', compact('posts', 'tag'));
    }
}
