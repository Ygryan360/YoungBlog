@extends('layouts.auth')
@section('title', 'Connexion')
@section('content')
    <form action="{{ route('login.post') }}" method="post">
        @csrf
        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs border p-4">
            <legend class="fieldset-legend text-2xl">Connexion</legend>

            <x-input label='Email' type='email' name='email' :required="true" placeholder='Email' :value="old('email')" />

            <x-input label='Mot de passe' type='password' name='password' :required="true" placeholder='Mot de passe' />

            <button class="btn btn-primary mt-4" type="submit">Connexion</button>
            @error('email')
                <p class="mt-2 text-error font-bold">
                    {{ $message }}
                </p>
            @enderror
        </fieldset>
    </form>
@endsection
