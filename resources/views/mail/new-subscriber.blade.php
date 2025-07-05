<x-mail::message>
# Veuillez confirmer votre abonnement à la newsletter de YoungBlog

Pour confirmer votre abonnement, veuillez cliquer sur le bouton ci-dessous :

<x-mail::button :url="route('newsletter', ['email' => $email, 'token' => $token])">
Confirmer l'abonnement
</x-mail::button>

Si vous ne pouvez pas cliquer sur le bouton, veuillez copier et coller l'URL suivante dans votre navigateur :
<a href="{{ route('newsletter', ['email' => $email, 'token' => $token]) }}">{{ route('newsletter', ['email' => $email, 'token' => $token]) }}</a>

<x-mail::panel>
Ce mail a été envoyé pour confirmer votre abonnement à la newsletter de YoungBlog. 
Si vous n'avez pas demandé cet abonnement, vous pouvez ignorer ce message.
Si vous avez des questions, n'hésitez pas à me contacter.
</x-mail::panel>

Merci,<br>
{{ config('app.name') }}
</x-mail::message>
