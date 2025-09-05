@php
    $navLinks = [
        ['route' => 'home', 'label' => 'Accueil'],
        ['route' => 'about', 'label' => 'À propos'],
        ['route' => 'contact', 'label' => 'Contact'],
    ];
    if (auth()->check() && auth()->user()->id) {
        $navLinks[] = ['route' => 'profile', 'label' => 'Profil'];
    } else {
        $navLinks[] = ['route' => 'register', 'label' => 'S\'inscrire'];
        $navLinks[] = ['route' => 'login', 'label' => 'Se connecter'];
    }
@endphp

<ul class="menu w-full">
    @foreach ($navLinks as $link)
        <li class="{{ request()->routeIs($link['route']) ? 'text-primary font-medium' : '' }}">
            <a href="{{ route($link['route']) }}" title="{{ $link['label'] }}"
                class="justify-center">{{ $link['label'] }}</a>
        </li>
    @endforeach
</ul>
