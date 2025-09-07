@extends('layouts.guest')

@section('title', 'Interdit')

@section('content')
    <div class="mb-8 border-b border-base-200 pb-4">
        <h1 class="text-3xl font-bold mb-1 text-white">Accès interdit</h1>
        <p>Oups, vous n'avez pas l'autorisation d'accéder à cette page.</p>
    </div>
    <div class="flex flex-col items-center justify-center">
        <x-illustrations.403 class="h-32 mb-8" />
        <p class="text-lg mb-8 text-center">
            Petit(e) curieux(se), il semble que tu n'aies pas l'autorisation d'accéder à cette page ;-)
        </p>
        <a href="{{ route('home') }}" class="btn btn-primary">Retourner à l'accueil</a>
    </div>
@endsection
