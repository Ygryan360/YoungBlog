<div class="flex gap-1">
    <button class="btn btn-ghost" wire:click="toggleShowSearch">
        <x-lucide-search class="h-6" />
    </button>
    @if ($showSearch)
        <div
            class="h-screen w-screen fixed top-0 left-0 backdrop-blur-md bg-black/50 z-50 pt-10 flex
        justify-center">
            <label>
                <x-lucide-x class="h-6 absolute top-8 right-8 cursor-pointer" wire:click="toggleShowSearch" />
            </label>
            <div class="bg-base-300 p-8 min-w-4/5 max-w-lg flex flex-col max-h-fit min-h-96">
                <label class="input w-full">
                    <x-lucide-search class="h-4" />
                    <input type="search" placeholder="Rechercher" wire:model.debounce.500ms.live="search" />
                </label>
                <div class="mt-4">
                    @if ($search)
                        @if ($searchResults->isEmpty())
                            <p>Aucun résultat trouvé.</p>
                        @else
                            <h2 class="text-lg font-semibold mb-2">Résultats pour "{{ $search }}"</h2>
                            <div class="overflow-x-auto">
                                <table class="table">
                                    <tbody>
                                        @foreach ($searchResults as $result)
                                            <tr class="mb-1 flex gap-4">
                                                <th class="text-primary font-normal">{{ $result->category->name }}</th>
                                                <td class="font-bold">
                                                    <a href="{{ $result->route() }}"
                                                        class="hover:underline">{{ $result->title }}</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    @else
                        <p class="text-base-content/50 text-center">Commencez à taper pour rechercher des articles.</p>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
