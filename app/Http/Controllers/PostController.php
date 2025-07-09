<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\NewsletterFollower;

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

    public function category(string $slug)
    {
        return abort(404);
        // $category = Category::where('slug', $slug)->firstOrFail();
        // $posts = $category->posts()
        //     ->published()
        //     ->paginate(10);

        // return view('category', compact('posts', 'category'));
    }

    public function tag(string $name)/** : View **/
    {
        return abort(404);
        // $tag = Tag::where('name', $name)->firstOrFail();
        // $posts = $tag->posts()
        //     ->published()
        //     ->paginate(10);

        // return view('tag', compact('posts', 'tag'));
    }

    public function newsletter(Request $request)
    {
        $message = '';

        $email = $request->input('email');
        $token = $request->input('token');

        $subscriber = NewsletterFollower::where('email', $email)
            ->where('token', $token)
            ->first();

        if ($subscriber) {

            $subscriber->update(['verified' => true, 'token' => null]);
            $subscriber->save();

            $message = "Merci pour votre abonnement à la newsletter de YoungBlog. Vous recevrez bientôt nos dernières actualités et articles directement dans votre boîte de réception.";

        } else {
            $message = "Aucun abonnement trouvé pour cette adresse e-mail.";
        }

        return redirect()->route('home')->with('message', $message);
    }
}
