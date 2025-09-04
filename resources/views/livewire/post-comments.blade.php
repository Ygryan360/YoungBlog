@php
    $count = count($comments);
@endphp

<div>
    <h3 class="text-2xl font-bold text-white mb-4">
        <x-heroicon-o-chat-bubble-left-right class="h-6 text-primary inline-block mr-2" />
        {{ $count }} Commentaire{{ $count > 1 ? 's' : '' }}
    </h3>

    <div class="mt-6 mb-8">
        @auth
            <form wire:submit.prevent="submit">
                <textarea wire:model.defer="newComment" rows="4" class="textarea textarea-bordered w-full"
                    placeholder="Laisser un commentaire..."></textarea>
                <div class="mt-2">
                    <button class="btn btn-primary">Envoyer</button>
                </div>
            </form>
        @else
            <p class="text-base-content/60">Vous devez être connecté pour poster un commentaire. <a
                    href="{{ route('login') }}">Se
                    connecter</a></p>
        @endauth
    </div>

    @foreach ($comments as $comment)
        <div class="mb-4">
            <div class="flex items-center justify-between mb-2">
                <div class="grid grid-cols-3 gap-2">
                    <div class="avatar">
                        <div class="w-14 h-14 rounded-full overflow-hidden">
                            @if (isset($comment['author']))
                                <img src="{{ $comment['author']['avatar_url'] ? \Illuminate\Support\Facades\Storage::url($comment['author']['avatar_url']) : asset('img/author-sm.png') }}"
                                    alt="{{ $comment['author']['name'] }}">
                            @else
                                <img src="{{ asset('img/author-sm.png') }}" alt="Anonyme">
                            @endif
                        </div>
                    </div>
                    <div class="h-full flex flex-col justify-between col-span-2">
                        <h4 class="font-bold">
                            {{ $comment['author']['name'] ?? 'Anonyme' }}
                        </h4>
                        <div class="flex gap-2">
                            <span class="text-sm text-base-content/60">
                                {{ \Carbon\Carbon::parse($comment['created_at'])->diffForHumans() }}
                            </span>
                            <button wire:click.prevent="toggleShowReplyForm"
                                class="flex cursor-pointer items-baseline gap-1">
                                <x-lucide-reply-all class="inline h-4 w-4" />
                                <span class="hover:underline">
                                    Répondre
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                @php
                    $canDelete =
                        auth()->check() &&
                        (auth()->id() === ($comment['author']['id'] ?? null) ||
                            (method_exists(auth()->user(), 'isAdmin') && auth()->user()->isAdmin()) ||
                            (method_exists(auth()->user(), 'isSuperAdmin') && auth()->user()->isSuperAdmin()));
                @endphp
                @if ($canDelete)
                    <button wire:click="deleteComment({{ $comment['id'] }})"
                        class="btn btn-sm btn-ghost text-error">Supprimer</button>
                @endif
            </div>

            <div class="prose mt-2 max-w-none">
                {!! nl2br(e($comment['content'])) !!}
            </div>

            @if (!empty($comment['replies']))
                <div class="mt-2 bg-base-200 p-4">
                    @foreach ($comment['replies'] as $reply)
                        <div class="pl-4 my-2">
                            <div class="flex gap-2 items-baseline">
                                <h6 class="font-medium">
                                    {{ $reply['author']['name'] ?? 'Anonyme' }}
                                </h6>
                                <span> - </span>
                                <span class="text-sm text-base-content/60">
                                    {{ \Carbon\Carbon::parse($reply['created_at'])->diffForHumans() }}
                                </span>
                            </div>
                            <p class="text-base-content/70">{{ $reply['content'] }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
            @if ($showReplyForm)
                @auth
                    <div class="mt-4">
                        <form wire:submit.prevent="submit({{ $comment['id'] }})">
                            <textarea wire:model.defer="replyText.{{ $comment['id'] }}" rows="2" class="textarea textarea-bordered w-full"
                                placeholder="Réponse..."></textarea>
                            <div class="mt-2">
                                <button class="btn btn-primary btn-sm" type="submit">Répondre</button>
                            </div>
                        </form>
                    </div>
                @endauth
            @endif
        </div>
    @endforeach
</div>
