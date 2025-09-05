@extends('layouts.auth')
@section('title', 'Connexion')
@section('content')
    <form action="{{ route('register.post') }}" method="post">
        @csrf
        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs border p-4">
            <legend class="fieldset-legend text-2xl">Inscription</legend>
            <x-input label='Nom' type='text' name='name' :required="true" placeholder='Junior Zeda' :value="old('name')"
                :witherror="true" />

            <x-input label='Email' type='email' name='email' :required="true" placeholder='mon@mail.com'
                :value="old('email')" :witherror="true" />

            <x-input label='Mot de passe' type='password' name='password' :required="true" placeholder='∙∙∙∙∙∙∙∙'
                :witherror="true" />

            <x-input label='Confirmation du mot de
                passe' type='password' name='password_confirmation'
                :required="true" placeholder='∙∙∙∙∙∙∙∙' />

            <button class="btn btn-primary mt-2" type="submit">S'inscrire</button>

            <div class="mt-4 text-center">
                Vous êtes déjà inscrit ? <a href="{{ route('login') }}" class="link link-primary">Connectez-vous</a>
            </div>
        </fieldset>
    </form>
@endsection
