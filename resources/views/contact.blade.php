@extends('layouts.guest')

@section('title', 'Accueil')

@section('breadcrumbs')
    <div class="breadcrumbs text-sm">
        <ul>
            <li class="flex items-center gap-2">
                <x-lucide-mail-plus class="h-4" />
                Contact
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="mb-8 border-b border-base-200 pb-4">
        <h1 class="text-3xl font-bold mb-1 text-white">Me contacter</h1>
        <p>Vous pouvez me contacter via le formulaire ci-dessous.</p>
    </div>
    <livewire:contact-form />
@endsection
