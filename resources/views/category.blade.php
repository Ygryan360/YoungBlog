@extends('layouts.guest')

@section('title', $category->name)

@section('breadcrumbs')
    <div class="breadcrumbs text-sm">
        <ul>
            <li class="flex items-center gap-2">
                <x-lucide-home class="h-4 w-4 inline-block" />
                <span>Accueil</span>
            </li>
            <li class="flex items-center gap-2">
                <x-lucide-square-menu class="h-4 w-4 inline-block" />
                <a href="{{ $category->route() }}">{{ $category->name }}</a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="mb-8 border-b border-base-200 pb-4">
        <h1 class="text-3xl font-bold mb-1 text-white">{{ $category->name }}</h1>
        @if ($category->description)
            <p>{{ $category->description }}</p>
        @endif
    </div>

    <x-posts-container :posts="$posts" />

@endsection
