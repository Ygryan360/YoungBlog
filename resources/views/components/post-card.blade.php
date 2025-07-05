@props(['post'])

<article class="card bg-base-200 w-full md:w-md shadow-sm my-4">
    <figure>
        <a class="overflow-hidden" href="{{ route('posts.show', ['slug' => $post->slug, 'post' => $post->id]) }}">
            <img class="transition-transform duration-300 ease-in-out hover:scale-105 w-full h-auto"
                src="{{ $post->getImageUrl() }}" alt="{{ $post->title }}" />
        </a>
    </figure>
    <div class="card-body">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-1">
                <x-lucide-menu-square class="h-4 text-primary" />
                <span class="text-sm">{{ $post->category->name }}</span>
            </div>
            <div class="flex items-center gap-1">
                <x-lucide-calendar class="h-4 text-primary" />
                <span class="text-sm">{{ $post->created_at->format('d M Y') }}</span>
            </div>
        </div>
        <a href="{{ $post->route() }}"
            class="card-title text-white text-2xl">
            {{ $post->title }}
        </a>
        <p class="text-base-content">{{ $post->description }}</p>
        <div class="card-actions">
            <x-lucide-tags class="h-6 text-primary inline-block mr-2" />
            @foreach ($post->tags->take(3) as $tag)
                <span class="badge badge-outline">{{ $tag->name }}</span>
            @endforeach
        </div>
        <div class="card-actions mt-2">
            <a href="{{ $post->route() }}" class="btn btn-primary">
                Lire l'article
            </a>
        </div>
    </div>
</article>
