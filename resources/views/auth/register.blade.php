@extends('layouts.auth')
@section('title', 'Connexion')
@section('content')
    <form action="{{ route('register.post') }}" method="post">
        @csrf
        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs border p-4">
            <legend class="fieldset-legend text-2xl">Inscription</legend>

            <x-input label='Nom' type='text' name='name' :required="true" placeholder='Nom' :value="old('name')"
                :witherror="true" />

            <x-input label='Email' type='email' name='email' :required="true" placeholder='Email' :value="old('email')"
                :witherror="true" />

            <x-input label='Mot de passe' type='password' name='password' :required="true" placeholder='Mot de passe'
                :witherror="true" />

            <x-input label='Confirmation du mot de passe' type='password' name='password_confirmation' :required="true"
                placeholder='Confirmation du mot de passe' />

            <button class="btn btn-primary mt-4" type="submit">S'inscrire</button>
        </fieldset>
    </form>
@endsection
