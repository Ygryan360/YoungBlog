<x-mail::message>
    # Vérification de l'email

    Bonjour {{ $user->name }},
    Votre code de vérification est :

    <x-mail::panel>
        {{ $user->verification_code }}
    </x-mail::panel>

    Merci,<br>
    {{ config('app.name') }}
</x-mail::message>
