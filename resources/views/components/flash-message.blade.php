<div class="w-full flex justify-center">
    @if (session()->has('message'))
        <div role="alert" class="alert alert-success max-w-2xl">
            {{ $slot }}
            <span>{{ session('message') }}</span>
        </div>
    @endif
</div>