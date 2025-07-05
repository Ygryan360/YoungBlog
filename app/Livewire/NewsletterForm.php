<?php

namespace App\Livewire;

use App\Models\NewsletterFollower;
use App\Models\User;
use Illuminate\Support\Str;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewSubscriber;

class NewsletterForm extends Component
{
    public $email;
    protected $rules = [
        'email' => ['required', 'email'],
    ];
    public function subscribe(): void
    {
        $this->validate();

        if (
            User::where('email', $this->email)->exists() ||
            NewsletterFollower::where('email', $this->email)->exists()
        ) {
            session()->flash('message', 'Vous êtes déjà inscrit à la newsletter.');
            return;
        }

        $token = Str::random();

        Mail::to($this->email)->send(new NewSubscriber($this->email, $token));

        NewsletterFollower::create([
            'email' => $this->email,
            'token' => $token,
        ]);

        session()->flash(
            'message',
            'Un e-mail de confirmation a été envoyé à votre adresse. 
            Veuillez vérifier votre boîte de réception.'
        );

        $this->reset();
    }
    public function render()
    {
        return view('livewire.newsletter-form');
    }
}
