<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileForm extends Component
{
  use WithFileUploads;

  public $name;
  public $email;
  public $username;
  public $avatar;
  public $password;
  public $password_confirmation;

  public $user;

  protected function rules(): array
  {
    $id = auth()->id();

    return [
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($id)],
      'username' => ['nullable', 'string', 'max:255', Rule::unique('users', 'username')->ignore($id)],
      'avatar' => ['nullable', 'image', 'max:2048'],
      'password' => ['nullable', 'string', 'min:8', 'confirmed'],
    ];
  }

  public function mount(): void
  {
    $u = auth()->user();
    $this->user = $u;
    $this->name = $u->name;
    $this->email = $u->email;
    $this->username = $u->username;
  }

  public function save()
  {
    $this->validate();

    $user = $this->user;
    $dirtyEmail = $this->email !== $user->email;

    $user->name = $this->name;
    $user->email = $this->email;
    $user->username = $this->username;

    if ($this->avatar) {
      $path = $this->avatar->store('avatars', 'public');
      $user->avatar_url = $path;
    }

    if (!empty($this->password)) {
      // password will be hashed by model cast
      $user->password = $this->password;
    }

    if ($dirtyEmail) {
      $user->email_verified_at = null;
    }

    $user->save();

    session()->flash('success', 'Profil mis à jour.');
  }

  public function render()
  {
    return view('livewire.profile-form');
  }
}
