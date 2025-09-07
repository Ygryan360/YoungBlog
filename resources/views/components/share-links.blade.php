@props(['url', 'title'])
@php
    $url = urlencode($url);
    $title = urlencode($title);
    $text = $title . ' - ' . $url;
@endphp

<div class="dropdown dropdown-left">
    <div class="tooltip" data-tip="Partager">
        <div tabindex="0" role="button" class="btn btn-soft m-1">
            <x-lucide-share-2 class="h-6 text-primary inline-block mr-2" />
        </div>
    </div>
    <ul tabindex="0" class="dropdown-content menu bg-base-300 rounded-box z-1 w-72 p-2 shadow-sm">
        <li class="mb-4">
            <button onclick="copyToClipboard('{{ $url }}')">
                <x-heroicon-o-link class="h-6 w-6 mr-2" />
                Copier le lien
            </button>
        </li>
        <li>
            <a href="https://wa.me/?text={{ $text }}" target="_blank" title="Partager sur WhatsApp">
                <x-logo-whatsapp class="text-[#25D366] mr-2" />
                Partager sur WhatsApp
            </a>
        </li>
        <li>
            <a href="https://twitter.com/intent/tweet?text={{ $text }}" target="_blank"
                title="Partager sur X"><x-logo-x class="text-[#000000] mr-2" />Partager sur X</a>
        </li>
        <li>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $url }}" target="_blank"
                title="Partager sur Facebook"><x-logo-facebook class="text-[#1977F2] mr-2" />Partager
                sur Facebook</a>
        </li>
        <li>
            <a href="https://www.reddit.com/submit?url={{ $url }}&title={{ $title }}" target="_blank"
                title="Partager sur Reddit"><x-logo-reddit class="text-[#FF4500] mr-0.5" />Partager
                sur Reddit</a>
        </li>
        <li>
            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ $url }}&title={{ $title }}"
                target="_blank" title="Partager sur LinkedIn"><x-logo-linkedin class="text-[#0077B5] mr-2" />Partager
                sur LinkedIn</a>
        </li>
    </ul>
</div>
