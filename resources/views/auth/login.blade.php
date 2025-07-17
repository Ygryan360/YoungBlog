@extends('layouts.auth')
@section('title', 'Connexion')
@section('content')
    <form action="{{ route('login.post') }}" method="post">
        @csrf
        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs border p-4">
            <legend class="fieldset-legend text-2xl">Connexion</legend>

            <label class="label">Email</label>
            <input type="email" name="email" required class="input" placeholder="Email" value="{{ old('email') }}" />

            <label class="label">Mot de passe</label>
            <input type="password" name="password" required class="input" placeholder="Mot de passe" />

            <button class="btn btn-primary mt-4" type="submit">Connexion</button>
            @error('email')
                <p class="mt-2 text-error font-bold">
                    {{ $message }}
                </p>
            @enderror
        </fieldset>
    </form>
@endsection
