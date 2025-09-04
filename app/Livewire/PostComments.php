<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Livewire\Component;

class PostComments extends Component
{
  public Post $post;

  public array $comments = [];

  public string $newComment = '';

  public array $replyText = [];

  public ?int $replyTo = null;

  public bool $showReplyForm = false;

  protected $rules = [
    'newComment' => ['required', 'string', 'min:3', 'max:2000'],
  ];

  public function mount(Post $post)
  {
    $this->post = $post;
  }

  public function placeholder()
  {
    return <<<'HTML'
        <div class="flex items-center justify-center h-full w-full">
            <span class="loading loading-bars loading-xl"></span>
        </div>
        HTML;
  }

  public function submit(?int $parentId = null): void
  {
    if (!auth()->check()) {
      $this->dispatchBrowserEvent('redirect-to-login', ['url' => route('login')]);
      return;
    }

    $content = $parentId ? ($this->replyText[$parentId] ?? '') : $this->newComment;

    \Illuminate\Support\Facades\Validator::make([
      'content' => $content,
    ], [
      'content' => 'required|string|min:3|max:2000',
    ])->validate();

    $comment = Comment::create([
      'content' => $content,
      'parent_id' => $parentId,
      'post_id' => $this->post->id,
      'author_id' => auth()->id(),
    ]);

    if ($parentId) {
      $this->replyText[$parentId] = '';
    } else {
      $this->newComment = '';
    }
    $this->replyTo = null;

    session()->flash('success', 'Commentaire ajouté.');
  }

  public function deleteComment(int $id): void
  {
    $comment = Comment::findOrFail($id);
    Gate::authorize('delete', $comment);

    $comment->delete();

    session()->flash('success', 'Commentaire supprimé.');
  }

  public function toggleShowReplyForm()
  {
    $this->showReplyForm = !$this->showReplyForm;
  }

  public function render()
  {
    $this->comments = Comment::with(['author', 'replies.author'])
      ->where('post_id', $this->post->id)
      ->whereNull('parent_id')
      ->orderBy('created_at', 'desc')
      ->get()
      ->map(fn($c) => $c->toArray())
      ->toArray();

    return view('livewire.post-comments');
  }
}
