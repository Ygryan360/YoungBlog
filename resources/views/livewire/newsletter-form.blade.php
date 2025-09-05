<div class="w-full pt-8 text-center border-t border-base-200">
    <h3 class="text-xl font-bold mb-2 text-white">Abonnez-vous à la newsletter</h3>
    <p class="mb-4 font-light max-w-xl mx-auto">
        Abonnez-vous à la newsletter pour recevoir les
        dernières nouvelles et mises à jour directement
        dans votre boîte de réception.
    </p>
    <form class="join mb-4" wire:submit.prevent="subscribe">
        <div>
            <label class="input validator join-item">
                <x-lucide-bell class="h-4" />
                <input type="email" placeholder="mail@site.com" required wire:model="email" />
            </label>
            @error('email')
                <div class="text-sm text-error mt-2">Entrez un email valide !</div>
            @enderror
        </div>
        <button class="btn btn-neutral join-item" type="submit">S'abonner</button>
    </form>
    <x-flash-message>
        <x-lucide-bell-ring class="h-4" />
    </x-flash-message>
</div>
