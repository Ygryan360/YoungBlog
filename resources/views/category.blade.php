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
    <div class="w-full flex justify-center gap-10 flex-wrap">
        @if ($posts->isEmpty())
            <div class="flex flex-col items-center justify-center">
                <x-illustrations.reading class="w-70 mb-4" />
                <p class="text-lg">
                    Aucun article trouvé, mais j'y travaille ;-)
                </p>
            </div>
        @else
            @foreach ($posts as $post)
                <x-post-card :post="$post" />
            @endforeach
            {{ $posts->links() }}
        @endif
    </div>

@endsection
