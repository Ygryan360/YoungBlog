<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <title>YoungBlog - @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:200,300,400,500,600,700,800" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased h-screen w-full flex flex-col md:flex-row">
    <section class="w-full md:w-1/2 h-screen flex items-center justify-center p-8">
        @yield('content')
    </section>
    <section
        class="w-full md:w-1/2 h-screen bg-base-200 border-base-300 border p-4 flex flex-col items-center justify-center">
        <img src="{{ asset('img/logo.svg') }}" alt="YoungBlog Logo" class="w-34 mb-8">
        <img src="{{ asset('img/sign-up.svg') }}" alt="Se connecter" class="w-1/2">
    </section>
</body>

</html>
