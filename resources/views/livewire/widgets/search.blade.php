<div class="flex gap-1">
    <button class="btn btn-ghost" wire:click="toggleShowSearch">
        <x-lucide-search class="h-6" />
    </button>
    @if($showSearch)
        <div class="h-screen w-screen fixed top-0 left-0 backdrop-blur-md bg-base-100/30 z-50 pt-10 flex
        justify-center">
            <label >
                <x-lucide-x class="h-6 absolute top-8 right-8 cursor-pointer" wire:click="toggleShowSearch" />
            </label>
            <div class="bg-base-300 p-8 min-w-4/5 max-w-lg flex flex-col max-h-fit min-h-96">
                <label class="input w-full">
                    <x-lucide-search class="h-4"/>
                    <input type="search"  placeholder="Rechercher" wire:model.debounce.500ms.live="search" />
                </label>
                <div class="mt-4">
                    @if($search)
                        @if($searchResults->isEmpty())
                            <p class="text-base-content/50">Aucun résultat trouvé.</p>
                        @else
                        <h2 class="text-lg font-semibold mb-2">Résultats pour "{{ $search }}"</h2>
                            <ul class="list-disc pl-5">
                                @foreach($searchResults as $result)
                                    <li class="mb-1">
                                        <a href="{{ route('posts.show', $result) }}" class="text-primary hover:underline">
                                            {{ $result->title }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    @else
                        <p class="text-base-content/50 text-center">Commencez à taper pour rechercher des articles.</p>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
