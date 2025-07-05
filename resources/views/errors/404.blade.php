@extends('layouts.guest')

@section('title', 'Page non trouvée')

@section('content')
    <div class="mb-8 border-b border-base-200 pb-4">
        <h1 class="text-3xl font-bold mb-1 text-white">Page non trouvée</h1>
        <p>Oups, la page que vous recherchez n'existe pas.</p>
    </div>
    <div class="flex flex-col items-center justify-center">
        <x-illustrations.404 class="w-1/3 mb-8"/>
        <p class="text-lg mb-8">
            Il semble que la page que vous cherchez n'existe pas ou a été déplacée.
        </p>
        <a href="{{ route('home') }}" class="btn btn-primary">Retourner à l'accueil</a>
    </div>
@endsection
