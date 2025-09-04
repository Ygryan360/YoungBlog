<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class PostsContainer extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public function placeholder()
    {
        return <<<'HTML'
        <div class="flex w-full mb-10 h-full items-center gap-10 flex-wrap justify-center">
            <div class="skeleton h-80 w-70"></div>
            <div class="skeleton h-80 w-70"></div>
            <div class="skeleton h-80 w-70"></div>
        </div>
        HTML;
    }

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
