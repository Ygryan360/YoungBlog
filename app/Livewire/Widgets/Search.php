<?php

namespace App\Livewire\Widgets;

use App\Models\Post;
use Livewire\Component;

class Search extends Component
{
    public bool $showSearch = false;

    public string $search = '';

    public function toggleShowSearch(): bool
    {
        return $this->showSearch = !$this->showSearch;
    }

    public function getSearchResults(): mixed
    {
        return Post::whereLike('name', '%' . $this->search . '%')
            ->orWhereLike('content', '%' . $this->search . '%')
            ->orWhereLike('tags', '%' . $this->search . '%')
            ->take(10)
            ->get();
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.widgets.search', [
            'showSearch' => $this->showSearch,
            'searchResults' => $this->search ? $this->getSearchResults() : [],
        ]);
    }
}
