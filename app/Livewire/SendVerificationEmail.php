<?php

namespace App\Livewire;

use Livewire\Component;

class SendVerificationEmail extends Component
{
    public $disabled = false;
    public $countdown = 0;
    private $user;

    public function mount()
    {
        $this->countdown = session('verification_countdown', 0);
        $this->disabled = $this->countdown > 0;
    }

    public function sendEmail()
    {
        $this->user = auth()->user();

        if ($this->user->hasVerifiedEmail() || $this->disabled) {
            return;
        }

        $this->disabled = true;
        $this->countdown = 30;

        session(['verification_countdown_start' => now()->timestamp]);

        $this->user->sendEmailVerificationCode();
    }

    public function updateCountdown()
    {
        $startTime = session('verification_countdown_start');

        if ($startTime) {
            $elapsed = now()->timestamp - $startTime;
            $remaining = max(0, 30 - $elapsed);

            $this->countdown = $remaining;
            $this->disabled = $remaining > 0;

            if ($remaining <= 0) {
                session()->forget('verification_countdown_start');
            }
        }
    }

    public function render()
    {
        $this->updateCountdown();
        return view('livewire.send-verification-email');
    }
}
