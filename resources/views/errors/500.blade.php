@extends('layouts.guest')

@section('title', 'Erreur du serveur')

@section('content')
    <div class="mb-8 border-b border-base-200 pb-4">
        <h1 class="text-3xl font-bold mb-1 text-white">Erreur du serveur</h1>
        <p>Oups, quelque chose s'est mal passé sur notre serveur.</p>
    </div>
    <div class="flex flex-col items-center justify-center">
        <x-illustrations.500 class="w-1/3 mb-8"/>
        <p class="text-lg mb-8 text-center">
            Il semble que quelque chose se soit mal passé sur notre serveur.
        </p>
        <a href="{{ route('home') }}" class="btn btn-primary">Retourner à l'accueil</a>
    </div>
@endsection
