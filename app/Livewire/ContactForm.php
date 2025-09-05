<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;

class ContactForm extends Component
{
    public $name;
    public $email;
    public $content;
    public $captcha;
    public $captchaA;
    public $captchaB;

    protected $rules = [
        'name' => ['required', 'string', 'max:255', 'min:4'],
        'email' => ['required', 'email', 'max:255'],
        'content' => ['required', 'string', 'max:1000', 'min:128'],
        'captcha' => ['required', 'numeric'],
    ];

    public function mount(): void
    {
        if (empty($this->captchaA) || empty($this->captchaB)) {
            $this->regenerateCaptcha();
        }
    }

    public function submit()
    {
        $this->validate();

        if ((int) $this->captcha !== ($this->captchaA + $this->captchaB)) {
            $this->addError('captcha', 'La réponse au captcha est incorrecte.');
            return;
        }

        Message::create([
            'name' => $this->name,
            'email' => $this->email,
            'content' => $this->content
        ]);

        session()->flash('message', 'Votre message a été envoyé avec succès.');

        $this->reset(['name', 'email', 'content', 'captcha']);
        $this->regenerateCaptcha();
    }

    protected function regenerateCaptcha(): void
    {
        $this->captchaA = rand(1, 9);
        $this->captchaB = rand(1, 9);
        $this->captcha = null;
    }

    public function render()
    {
        if (auth()->check() && auth()->user()) {
            $this->name = auth()->user()->name;
            $this->email = auth()->user()->email;
        }

        return view('livewire.contact-form');
    }
}
