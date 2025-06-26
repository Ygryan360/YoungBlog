<?php

namespace App\Livewire\Widgets;

use App\Models\Post;
use Illuminate\View\View;
use Livewire\Component;

class Search extends Component
{
    public bool $showSearch = false;

    public string $search = '';

    public function toggleShowSearch(): bool
    {
        return $this->showSearch = !$this->showSearch;
    }

    public function render(): View
    {
        return view('livewire.widgets.search', [
            'showSearch' => $this->showSearch,
            'searchResults' => $this->search ? $this->getSearchResults() : [],
        ]);
    }

    public function getSearchResults(): mixed
    {
        return Post::minimal()
            ->published()
            ->whereLike('title', '%' . $this->search . '%')
            ->orWhereLike('content', '%' . $this->search . '%')
            ->take(10)
            ->get();
    }
}
