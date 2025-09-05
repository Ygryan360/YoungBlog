@extends('layouts.auth')
@section('title', 'Connexion')
@section('content')
    <form action="{{ route('login.post') }}" method="post">
        @csrf
        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs border p-4">
            <legend class="fieldset-legend text-2xl">Connexion</legend>

            <x-input label='Email' type='email' name='email' :required="true" placeholder='mon@mail.com'
                :value="old('email')" />

            <x-input label='Mot de passe' type='password' name='password' :required="true" placeholder='∙∙∙∙∙∙∙∙' />

            <button class="btn btn-primary mt-2" type="submit">Connexion</button>

            @error('email')
                <p class="mt-2 text-error font-bold">
                    {{ $message }}
                </p>
            @enderror

            <div class="mt-4 text-center">
                Vous n'êtes pas encore inscrit ? <a href="{{ route('register') }}" class="link link-primary">S'inscrire</a>
            </div>
        </fieldset>
    </form>
@endsection
