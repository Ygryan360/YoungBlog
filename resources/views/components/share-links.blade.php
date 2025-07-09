@props(['url', 'title'])
@php
    $url = urlencode($url);
    $title = urlencode($title);
    $text = urlencode($title) . " - " . urlencode($url);
@endphp

<div class="w-full flex items-center gap-4">
    <div class="flex items-center">
        <x-lucide-share-2 class="h-6 text-primary inline-block mr-2" />
        <span class="text-white font-semibold">
            Partager :
        </span>
    </div>
    <a href="https://wa.me/?text={{ $text }}" class="btn bg-[#25D366]" target="_blank" title="Partager sur WhatsApp"><x-logo-whatsapp/></a>
    <a href="https://twitter.com/intent/tweet?text={{ $text }}" class="btn bg-[#000000]" target="_blank" title="Partager sur X"><x-logo-x/></a>
    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $url }}" class="btn bg-[#1977F2]" target="_blank" title="Partager sur Facebook"><x-logo-facebook/></a>
    <a href="https://www.reddit.com/submit?url={{ $url }}&title={{ $title }}" class="btn bg-[#FF4500]" target="_blank" title="Partager sur Reddit"><x-logo-reddit/></a>
    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ $url }}&title={{ $title }}" class="btn bg-[#0077B5]" target="_blank" title="Partager sur LinkedIn"><x-logo-linkedin/></a>
</div>