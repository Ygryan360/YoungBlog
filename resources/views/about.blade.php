@php

use App\Models\About;
$about = About::firstOrFail();
$about->increment('views');

@endphp

@extends('layouts.guest')

@section('title', 'A Propos')

@section('breadcrumbs')
    <div class="breadcrumbs text-sm">
        <ul>
            <li class="flex items-center gap-2">
                <x-lucide-info class="h-4" />
                A Propos
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="mb-8 border-b border-base-200 pb-4">
        <h1 class="text-3xl font-bold mb-1 text-white">A Propos</h1>
        <p>Voici quelques informations à propos de moi.</p>
    </div>
    <div class="flex justify-center mb-8">
        <div class="max-w-4xl">
            <img class="w-full h-auto mb-4 rounded shadow-lg" src="{{ $about->getImageUrl() }}"
                alt="Rayane Tchabodi">
            <article class="post-content pb-8">
                {!! $about->parsedContent() !!}
            </article>
        </div>
    </div>
@endsection
