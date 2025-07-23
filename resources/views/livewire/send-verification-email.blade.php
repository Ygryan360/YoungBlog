<div wire:poll.1s="updateCountdown">
    <button wire:click="sendEmail" class="btn btn-ghost font-medium" {{ $disabled ? 'disabled' : '' }}>
        @if ($countdown > 0)
            Renvoyer le code ({{ $countdown }}s)
        @else
            Renvoyer le code
        @endif
    </button>
</div>
