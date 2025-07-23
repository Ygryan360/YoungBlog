@extends('layouts.auth')
@section('title', 'Vérification de l\'email')
@section('content')
    <div class="text-center">
        <h1 class="text-4xl font-bold mb-4 text-white">Vérification de l'email :</h1>

        <p class="mb-4">
            Veuillez entrer le code qui vous a été envoyé par email pour vérifier votre adresse. Si vous n'avez pas reçu
            l'email, vous pouvez le renvoyer.
        </p>
        <div class="w-full flex flex-col justify-center items-center gap-4">
            <form method="post">
                @csrf
                <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs border p-4">
                    <legend class="fieldset-legend">Code de vérification</legend>
                    <x-input name="code" type="number" placeholder="XXXXXX" autofocus :required="true" />
                    @error('code')
                        <p class="mb-2 text-error font-bold">
                            Code invalide ou expiré.
                        </p>
                    @enderror
                    <button type="submit" class="btn btn-primary">Vérifier</button>
                </fieldset>
            </form>
            <livewire:send-verification-email />
        </div>
    </div>
@endsection
