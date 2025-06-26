@props(['post'])

<article class="card bg-base-200 w-full md:w-md shadow-sm my-4">
    <figure>
        <img class=" hover:transform-fill" src="{{ asset('img/cover.png') }}" alt="Cover" />
    </figure>
    <div class="card-body">
        <a href="{{ route('posts.show', ['slug' => $post->slug, 'post' => $post->id]) }}" class="card-title">
            {{ $post->title }}
        </a>
        <p>{{ $post->description }}</p>
        <div class="card-actions">
            <div class="badge badge-outline">{{ $post->category->name }}</div>
        </div>
        <div class="card-actions">
            <a href="{{ route('posts.show', ['slug' => $post->slug, 'post' => $post->id]) }}" class="btn btn-primary">
                Lire l'article
            </a>
        </div>
    </div>
</article>
