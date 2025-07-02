<div class="w-full flex justify-center gap-10 flex-wrap">
    @if ($posts->isEmpty())
        <div class="flex flex-col items-center justify-center">
            <x-illustrations.reading class="w-70 mb-4" />
            <p class="text-lg">
                Aucun article trouvé, mais j'y travaille ;-)
            </p>
        </div>
    @else
        @foreach ($posts as $post)
            <x-post-card :post="$post" />
        @endforeach
        {{ $posts->links() }}
    @endif
</div>
