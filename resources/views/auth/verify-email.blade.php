@extends('layouts.auth')
@section('title', 'Vérification de l\'email')
@section('content')
    <div class="text-center">
        <h1 class="text-2xl font-bold mb-4">Vérification de l'email</h1>
        <p class="mb-4">Un email de vérification a été envoyé à votre adresse. Veuillez vérifier votre boîte de réception.
        </p>
        <p class="mb-4">Si vous n'avez pas reçu l'email, vous pouvez le renvoyer.</p>

        <form action="{{ route('verification.send') }}" method="post">
            @csrf
            <button type="submit" class="btn btn-primary">Renvoyer l'email de vérification</button>
        </form>
    </div>
@endsection
