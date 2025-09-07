@extends('layouts.guest')

@section('title', $tag->name)

@section('breadcrumbs')
    <div class="breadcrumbs text-sm">
        <ul>
            <li class="flex items-center gap-2">
                <x-lucide-home class="h-4 w-4 inline-block" />
                <span>Accueil</span>
            </li>
            <li class="flex items-center gap-2">
                <x-lucide-tag class="h-4 w-4 inline-block" />
                <a href="{{ $tag->route() }}">{{ ucfirst($tag->name) }}</a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="mb-8 border-b border-base-200 pb-4">
        <h1 class="text-3xl font-bold mb-1 text-white">{{ ucfirst($tag->name) }}</h1>
    </div>

    <x-posts-container :posts="$posts" />
@endsection
