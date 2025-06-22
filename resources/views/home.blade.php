@extends('layouts.guest')

@section('title', 'Accueil')

@section('breadcrumbs')
    <div class="breadcrumbs text-sm">
        <ul>
            <li class="flex items-center">
                <i data-lucide="home" class="mr-1 w-4"></i>
                Accueil
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="mb-8 border-b border-base-200 pb-4">
        <h1 class="text-3xl font-bold mb-1">Bienvenue sur YoungBlog</h1>
        <p class="text-base-content/50">Découvrez mes dernières publications.</p>
    </div>
    <x-post-card />
    <x-post-card />
@endsection
