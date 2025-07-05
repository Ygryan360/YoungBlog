<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;

class ContactForm extends Component
{
    public $name;
    public $email;
    public $content;

    protected $rules = [
        'name' => ['required', 'string', 'max:255', 'min:4'],
        'email' => ['required', 'email', 'max:255'],
        'content' => ['required', 'string', 'max:1000', 'min:128'],
    ];

    public function submit()
    {
        $this->validate();

        Message::create([
            'name' => $this->name,
            'email' => $this->email,
            'content' => $this->content
        ]);

        session()->flash('message', 'Votre message a été envoyé avec succès.');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
