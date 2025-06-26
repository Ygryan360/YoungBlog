<div class="w-full flex justify-center gap-10 flex-wrap">
    @foreach($posts as $post)
        <x-post-card :post="$post"/>
    @endforeach
    {{ $posts->links() }}
</div>
