<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CommentController extends Controller
{
  use AuthorizesRequests;
  public function store(StoreCommentRequest $request, Post $post): RedirectResponse
  {
    $data = $request->validated();
    $data['author_id'] = auth()->id() ?? null;
    $data['post_id'] = $post->id;

    Comment::create($data);

    return redirect()->route('posts.show', ['slug' => $post->slug, 'post' => $post->id])->with('success', 'Commentaire ajouté.');
  }

  public function destroy(Comment $comment): RedirectResponse
  {
    $this->authorize('delete', $comment);

    $post = $comment->post;
    $comment->delete();

    return redirect()->route('posts.show', ['slug' => $post->slug, 'post' => $post->id])->with('success', 'Commentaire supprimé.');
  }
}
