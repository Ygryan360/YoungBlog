@extends('layouts.guest')

@section('title', $post->title)

@section('breadcrumbs')
    <div class="breadcrumbs text-sm">
        <ul>
            <li class="flex items-center gap-2">
                <x-lucide-home class="h-4" />
                <a href="{{ route('home') }}">Accueil</a>
            </li>
            <li class="flex items-center gap-2">
                <x-lucide-square-menu class="h-4" />
                <a href="{{ $post->category->route() }}">{{ $post->category->name }}</a>
            </li>
            <li>
                {{ $post->title }}
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="mb-8 border-b border-base-200 pb-4">
        <h1 class="text-3xl font-bold mb-1 text-white">{{ $post->title }}</h1>
        <p>Publié le <span class="text-white">{{ $post->created_at->format('d M Y') }}</span> par <span
                class="text-white">{{ $post->author->name }}</span>
        </p>
    </div>
    <div class="flex justify-center mb-8">
        <div class="max-w-4xl">
            @if ($post->image)
                <img class="w-full h-auto mb-4 rounded shadow-lg" src="{{ $post->getImageUrl() }}"
                    alt="{{ $post->title }}">
            @endif
            <article class="post-content mb-8 pb-6 border-b border-base-200">
                {!! $post->parsedContent() !!}
            </article>
            <div class="my-6">
                <div class="flex items-center">
                    <x-lucide-tags class="h-8 text-primary inline-block mr-2" />
                    <h4 class="text-lg font-semibold">Tags :</h4>
                    <div class="ml-4">
                        @foreach ($post->tags as $tag)
                            <a href="{{ $tag->route() }}" class="badge badge-outline mr-2">
                                {{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
