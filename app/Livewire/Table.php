<?php

namespace App\Livewire;

use Livewire\Component;

class Table extends Component
{
    public function render()
    {
        return view('livewire.table', [
            'users' => \App\Models\User::paginate(10),
        ]);
    }
}
