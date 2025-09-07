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
    <div class="flex justify-center mb-8">
        <div class="max-w-2xl px-4">
            <div class="mb-8">
                <h1 class="text-3xl font-bold mb-2 text-white">{{ $post->title }}</h1>
                <div class="w-full flex justify-between items-center">
                    <p class="block">
                        Publié le <span class="text-white">{{ $post->created_at->format('d M Y') }}</span> par <span
                            class="text-white">{{ $post->author->name }}</span>
                    </p>
                    <x-share-links :url="$post->route()" :title="$post->title" />
                </div>
            </div>
            @if ($post->image)
                <img class="w-full h-auto mt-4" src="{{ $post->getImageUrl() }}" alt="{{ $post->title }}">
            @endif
            <div class="mt-8 mb-4">
            </div>
            <article class="post-content mb-8 py-4">
                {!! $post->parsedContent() !!}
            </article>
            <div class="my-8">
                <div class="py-8">
                    <div class="flex items-center mb-8">
                        <h3 class="text-white text-2xl font-semibold">
                            <x-lucide-tags class="h-6 text-primary inline-block mr-2" />
                            Tags :
                        </h3>
                        <div class="ml-4">
                            @foreach ($post->tags as $tag)
                                <a href="{{ $tag->route() }}" class="badge badge-outline mr-2">
                                    {{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <livewire:post-comments :post="$post" lazy />
                </div>
            </div>
        </div>
    </div>
@endsection
