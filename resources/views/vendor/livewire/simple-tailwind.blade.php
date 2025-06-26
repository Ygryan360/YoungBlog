@php
    if (! isset($scrollTo)) {
        $scrollTo = 'body';
    }

    $scrollIntoViewJsSnippet = ($scrollTo !== false)
        ? <<<JS
           (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
        JS
        : '';
@endphp

<div>
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation" class="join">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="join-item btn">
                        {!! __('pagination.previous') !!}
                    </span>
            @else
                @if(method_exists($paginator,'getCursorName'))
                    <button type="button" dusk="previousPage"
                            wire:key="cursor-{{ $paginator->getCursorName() }}-{{ $paginator->previousCursor()->encode() }}"
                            wire:click="setPage('{{$paginator->previousCursor()->encode()}}','{{ $paginator->getCursorName() }}')"
                            x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled"
                            class="join-item btn">
                        {!! __('pagination.previous') !!}
                    </button>
                @else
                    <button
                        type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')"
                        x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled"
                        dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}"
                        class="join-item btn">
                        {!! __('pagination.previous') !!}
                    </button>
                    @endif
                    @endif
                    </span>

                    <span>
                {{-- Next Page Link --}}
                        @if ($paginator->hasMorePages())
                            @if(method_exists($paginator,'getCursorName'))
                                <button type="button" dusk="nextPage"
                                        wire:key="cursor-{{ $paginator->getCursorName() }}-{{ $paginator->nextCursor()->encode() }}"
                                        wire:click="setPage('{{$paginator->nextCursor()->encode()}}','{{ $paginator->getCursorName() }}')"
                                        x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled"
                                        class="join-item btn">
                                {!! __('pagination.next') !!}
                        </button>
                            @else
                                <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')"
                                        x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled"
                                        dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}"
                                        class="join-item btn">
                                {!! __('pagination.next') !!}
                        </button>
                            @endif
                        @else
                            <span
                                class="join-item btn">
                        {!! __('pagination.next') !!}
                    </span>
                @endif
        </nav>
    @endif
</div>
