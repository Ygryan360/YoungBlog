<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Gate;
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
        <div class="mt-8">
          <h3 class="text-2xl font-bold mb-4 text-white">Commentaires</h3>
          <div class="flex flex-col">
            <div class="flex w-full flex-col gap-4">
              <div class="flex items-center gap-4">
                <div class="skeleton h-16 w-16 shrink-0 rounded-full"></div>
                <div class="flex flex-col gap-4">
                  <div class="skeleton h-4 w-40"></div>
                  <div class="skeleton h-4 w-20"></div>
                </div>
              </div>
              <div class="skeleton h-32 w-full"></div>
            </div>
          </div>
        </div>
        HTML;
  }

  public function submit(?int $parentId = null)
  {
    if (!auth()->check()) {
      return redirect()->route('login');
    }

    $content = $parentId ? ($this->replyText[$parentId] ?? '') : $this->newComment;

    \Illuminate\Support\Facades\Validator::make([
      'content' => $content,
    ], [
      'content' => ['required', 'string', 'min:3', 'max:2000'],
    ])->validate();

    Comment::create([
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
