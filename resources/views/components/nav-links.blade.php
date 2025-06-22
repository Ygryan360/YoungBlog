@php
    $navLinks = [
        ['route' => 'home', 'label' => 'Accueil'],
        ['route' => 'about', 'label' => 'À propos'],
        ['route' => 'contact', 'label' => 'Contact'],
    ];
@endphp

<ul class="menu w-full">
    @foreach ($navLinks as $link)
        <li
            class="hover:border-b-2 border-base-300 {{ request()->routeIs($link['route']) ? 'text-primary font-bold' : '' }}">
            <a href="{{ route($link['route']) }}" title="{{ $link['label'] }}">{{ $link['label'] }}</a>
        </li>
    @endforeach
</ul>
