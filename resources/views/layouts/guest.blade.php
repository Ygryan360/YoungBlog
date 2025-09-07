<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <title>YoungBlog - @yield('title', 'Accueil')</title>
    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-sans antialiased">
    <div class="drawer lg:drawer-open">
        <input id="main-drawer" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content bg-base-200">
            <div class="flex w-full justify-center p-4 min-h-screen">
                <div class="container">
                    <div class="flex flex-col-reverse lg:flex-row mb-4 justify-between">
                        @yield('breadcrumbs')

                        <div class="flex items-center justify-between mb-4">
                            <a href="/" class="lg:hidden" title="Retour à l'accueil">
                                <img src="{{ asset('img/logo-ygr.png') }}" alt="YoungBlog Logo" class="h-10" />
                            </a>

                            <div class="flex">
                                <livewire:widgets.search />
                                <label for="main-drawer" class="btn btn-ghost drawer-button lg:hidden">
                                    <x-lucide-menu class="h-7" />
                                </label>
                            </div>
                        </div>

                    </div>
                    @yield('content')
                </div>
            </div>
            <x-footer />
        </div>
        <div class="drawer-side">
            <label for="main-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
            <div class="min-h-screen bg-base-100 w-70 px-4 py-8 flex flex-col gap-4 justify-between">
                <a href="/" title="Retour à l'accueil">
                    <x-logo class="w-34 mx-auto" />
                </a>
                <x-nav-links />
                <x-social-links />
            </div>
        </div>
    </div>

    @livewireScripts
</body>

</html>
