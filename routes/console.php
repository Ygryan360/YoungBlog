<?php

use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('create-ygr', function () {
    User::create([
        'email' => 'ygryan360@gmail.com',
        'name' => 'Rayane Tchabodi',
        'username' => 'ygryan360',
        'password' => Hash::make('password'),
        'role' => \App\Enums\UserRole::Superadmin->value,
    ]);
    $this->comment("L'utilisateur SuperAdmin a été créé !");
})->purpose('Créer un utilisateur superadmin');