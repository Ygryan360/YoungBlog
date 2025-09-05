@extends('layouts.guest')

@section('title', 'Accueil')

@section('breadcrumbs')
    <div class="breadcrumbs text-sm">
        <ul>
            <li class="flex items-center gap-2">
                <x-lucide-home class="h-4 w-4 inline-block" />
                <span>Accueil</span>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="mb-8 border-b border-base-200 pb-4">
        <h1 class="text-3xl font-bold mb-1 text-white">Bienvenue sur YoungBlog</h1>
        <p>Découvrez mes dernières publications.</p>
    </div>
    <x-flash-message>
        <x-lucide-circle-check class="h-4" />
    </x-flash-message>
    <livewire:posts-container lazy />
@endsection
