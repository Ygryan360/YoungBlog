<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class PostsContainer extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public function render()
    {
        return view('livewire.posts-container', [
            'posts' => Post::minimal()
                ->published()
                ->with(['author', 'category'])
                ->latest()
                ->paginate(10),
        ]);
    }
}
