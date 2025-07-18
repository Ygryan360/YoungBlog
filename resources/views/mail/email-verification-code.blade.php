<x-mail::message>
    # Vérification de l'email

    Votre code de vérification est :

    <x-mail::panel>
        {{ $verificationCode }}
    </x-mail::panel>

    <x-mail::button :url="''">
        Vérifier l'email
    </x-mail::button>

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
