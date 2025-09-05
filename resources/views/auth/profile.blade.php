@extends('layouts.guest')

@section('title', 'Profil')

@section('breadcrumbs')
    <div class="breadcrumbs text-sm">
        <ul>
            <li class="flex items-center gap-2">
                <x-lucide-home class="h-4 w-4" />
                <a href="{{ route('home') }}">Accueil</a>
            </li>
            <li>
                Profil
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="mb-8 pb-4">
        <h1 class="text-3xl font-bold mb-1">Profil</h1>
        <p class="text-base-content/70">Gérer mon compte</p>
    </div>
    <div class="flex justify-center mb-8">

    </div>
@endsection
