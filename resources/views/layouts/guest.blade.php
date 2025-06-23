<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>YoungBlog - @yield('title', 'Accueil')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:200,300,400,500,600,700,800" rel="stylesheet" />
    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-sans antialiased">
    <div class="drawer lg:drawer-open">
        <input id="main-drawer" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content ">
            <div class="flex justify-center p-4">
                <div class="container">
                    <div class="flex mb-2 justify-between">
                            @yield('breadcrumbs')
                        <div class="flex">
                        <livewire:widgets.search />
                        <label for="main-drawer" class="btn btn-ghost drawer-button lg:hidden">
                            <x-lucide-menu class="h-7" />
                        </label>
                        </div>
                    </div>
                    @yield('content')
                </div>
            </div>
            <x-footer />
        </div>
        <div class="drawer-side">
            <label for="main-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
            <div class="bg-base-200 text-base-content min-h-full w-70 px-4 py-8 flex flex-col justify-between">
                <a href="/" title="Retour à l'accueil">
                    <img src="{{ asset('img/logo.svg') }}" alt="YoungBlog Logo" class=" w-34 mx-auto">
                </a>
                <x-nav-links />
                <x-social-links />
            </div>
        </div>
    </div>

    @livewireScripts
</body>

</html>
